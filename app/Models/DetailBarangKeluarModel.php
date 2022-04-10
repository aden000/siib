<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailBarangKeluarModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_barang_keluar';
    protected $primaryKey       = 'id_detail_barang_keluar';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_barang_keluar', 'id_barang', 'kuantitas', 'id_satuan'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_barang_keluar' => 'required|numeric',
        'id_barang' => 'required|numeric',
        'kuantitas' => 'required|numeric',
        'id_satuan' => 'required|numeric',
    ];
    protected $validationMessages   = [
        'id_barang_keluar' => [
            'required' => 'Barang Keluar harus di isi',
            'numeric' => 'Input untuk "id_barang_keluar" tidak sesuai ',
        ],
        'id_barang' => [
            'required' => 'Barang harus di isi',
            'numeric' => 'Input untuk "id_barang" tidak sesuai ',
        ],
        'kuantitas' => [
            'required' => 'Kuantitas harus di isi',
            'numeric' => 'Kuantitas harus berupa angka',
        ],
        'id_satuan' => [
            'required' => 'Satuan harus di isi',
            'numeric' => 'Satuan harus berupa angka',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ["kurangiKuantitasBarang"];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function kurangiKuantitasBarang(array $data)
    {
        $idBarang = $data['data']['id_barang'];
        $idSatuan = $data['data']['id_satuan'];
        $kuantitas = $data['data']['kuantitas'];

        $detailBarangModel = new DetailBarangModel();
        $result = $detailBarangModel->where('id_satuan', $idSatuan)
            ->where('id_barang', $idBarang)
            ->select('kuantitas')
            ->first();

        $kuantitasNow = $result['kuantitas'] - $kuantitas;
        // dd($kuantitasNow);
        $detailBarangModel->where('id_barang', $idBarang)
            ->where('id_satuan', $idSatuan)
            ->set([
                'kuantitas' => $kuantitasNow
            ])->update();
        return $data;
    }
}
