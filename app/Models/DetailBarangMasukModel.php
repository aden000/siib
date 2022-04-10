<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailBarangMasukModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_barang_masuk';
    protected $primaryKey       = 'id_detail_barang_masuk';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_barang_masuk', 'id_barang', 'kuantitas', 'id_satuan'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_barang_masuk' => 'required|numeric',
        'id_barang' => 'required|numeric',
        'kuantitas' => 'required|greater_than_equal_to[0]',
        'id_satuan' => 'required|numeric'
    ];
    protected $validationMessages   = [
        'id_barang_masuk' => [
            'required' => 'Barang Masuk diperlukan',
            'numeric' => 'Barang Masuk harus berupa angka'
        ],
        'id_barang' => [
            'required' => 'Barang diperlukan',
            'numeric' => 'Barang harus berupa angka'
        ],
        'kuantitas' => [
            'required' => 'Kuantitas diperlukan',
            'greater_than_equal_to' => 'Barang Masuk harus berupa angka dan lebih dari sama dengan 0'
        ],
        'id_satuan' => [
            'required' => 'Satuan diperlukan',
            'numeric' => 'Satuan harus berupa angka'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = ["tambahKuantitasBarang"];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected function tambahKuantitasBarang(array $data)
    {
        $idBarang = $data['data']['id_barang'];
        $idSatuan = $data['data']['id_satuan'];
        $kuantitas = $data['data']['kuantitas'];

        $detailBarangModel = new DetailBarangModel();
        $result = $detailBarangModel->where('id_satuan', $idSatuan)
            ->where('id_barang', $idBarang)
            ->select('kuantitas')
            ->first();

        $kuantitasNow = $result['kuantitas'] + $kuantitas;
        // dd($kuantitasNow);
        $detailBarangModel->where('id_barang', $idBarang)
            ->where('id_satuan', $idSatuan)
            ->set([
                'kuantitas' => $kuantitasNow
            ])->update();
        return $data;
    }
}
