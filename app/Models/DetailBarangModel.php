<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailBarangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detail_barang';
    protected $primaryKey       = 'id_detail_barang';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_barang', 'id_satuan', 'kuantitas', 'turunan_id_satuan', 'konversi_turunan'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_barang' => 'required',
        'id_satuan' => 'required',
        'kuantitas' => 'required',
        'turunan_id_satuan' => 'required',
        'konversi_turunan' => 'required|greater_than_equal_to[0]'
    ];
    protected $validationMessages   = [
        'id_barang' => [
            'required' => 'Field id barang dibutuhkan'
        ],
        'id_satuan' => [
            'required' => 'Field id satuan dibutuhkan'
        ],
        'kuantitas' => [
            'required' => 'Field kuantitas dibutuhkan'
        ],
        'turunan_id_satuan' => [
            'required' => 'Field turunan id satuan dibutuhkan'
        ],
        'konversi_turunan' => [
            'required' => 'Field konversi turunan dibutuhkan',
            'greater_than_equal_to' => 'Field konversi turunan harus lebih dari sama dengan 0'
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * @return int affected rows
     */
    public function hapusDetailBarangBerdasarkanIDBarang($idBarang)
    {
        $old = count($this->findAll());
        $this->query("
            DELETE FROM detail_barang 
            WHERE detail_barang.id_barang = $idBarang;
        ");
        $new = count($this->findAll());

        return ($old - $new);
    }

    public function ambilDetailBarangBerdasarkanIDBarang($idBarang)
    {
        $result = $this->select('*')
            ->where('id_barang', $idBarang)
            ->findAll();

        return $result;
    }

    public function ambilDetailBarangAtasanBerdasarkanIDBarangDanIDSatuan($idBarang, $idSatuan)
    {
        $result = $this->select('*')
            ->where('id_barang', $idBarang)
            ->where('turunan_id_satuan', $idSatuan)
            ->first();

        return $result;
    }

    public function ambilDetailBarangBerdasarkanIDBarangDanIDSatuan($idBarang, $idSatuan)
    {
        $result = $this->select('*')
            ->where('id_barang', $idBarang)
            ->where('id_satuan', $idSatuan)
            ->first();

        return $result;
    }

    public function ambilKuantitasDariAtasanSatuan(int $idBarang, int $IDSatuanRepresentatif, int $banyaknyaKuantitasAtasan)
    {
        //ambil kuantitas, id satuan, dan konversi turunan atasan dari id satuan representatif 
        // (yang akan ditambahkan kuantitasnya)
        $resultAtasanSatuan = $this->select('id_detail_barang, id_satuan, kuantitas, konversi_turunan')
            ->where('id_barang', $idBarang)
            ->where('turunan_id_satuan', $IDSatuanRepresentatif)
            ->first();
        $idDetailBarangAtasan = $resultAtasanSatuan['id_detail_barang'];
        // d($resultAtasanSatuan);

        $kuantitasAtasan = $resultAtasanSatuan['kuantitas'];
        $konversiTurunan = $resultAtasanSatuan['konversi_turunan'];

        //ambil data kuantitas saat ini pada satuan yang akan ditambah kuantitasnya
        $resultRepresentatif = $this->select('id_detail_barang, kuantitas')
            ->where('id_barang', $idBarang)
            ->where('id_satuan', $IDSatuanRepresentatif)
            ->first();

        $idDetailBarangPilihan = $resultRepresentatif['id_detail_barang'];
        $kuantitasRepresentatif = $resultRepresentatif['kuantitas'];
        // d($resultRepresentatif);

        // dd($kuantitasRepresentatif + ($konversiTurunan * $banyaknyaKuantitasAtasan));

        //update isi kuantitas pada id satuan representatif
        $this->update($idDetailBarangPilihan, [
            'kuantitas' => $kuantitasRepresentatif + ($konversiTurunan * $banyaknyaKuantitasAtasan)
        ]);

        //update isi kuantitas pada id satuan atasan
        $this->update($idDetailBarangAtasan, [
            'kuantitas' => $kuantitasAtasan - $banyaknyaKuantitasAtasan
        ]);

        $result = [
            'success' => empty($this->errors()),
            'msg' => $this->errors()
        ];
        return $result;
    }
}
