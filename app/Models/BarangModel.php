<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'barang';
    protected $primaryKey       = 'id_barang';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_kategori_barang', 'nama_barang'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_kategori_barang' => 'required|numeric',
        'nama_barang' => 'required',
    ];
    protected $validationMessages   = [
        'id_kategori_barang' => [
            'required' => 'Kategori Barang dibutuhkan',
            'numeric' => 'Inputan Kategori Barang ID Harus berupa angka',
        ],
        'nama_barang' => [
            'required' => 'Nama barang dibutuhkan',
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

    public function buatBarangBaruDanDetailBarang(array $barang, array $daftarSatuan, array $daftarTurunan, array $daftarKonversi, int $banyaknyaDetailBarang)
    {
        $bool = TRUE;
        // $builder = $this->db->table('barang');
        // bdb = Builder Detail Barang Model
        $bdb = new DetailBarangModel();
        $this->insert($barang);
        if (empty($this->errors())) {
            $idBarang = $this->getInsertID();

            // ddb = Data Detail Barang
            $ddb = [];
            for ($i = 0; $i < $banyaknyaDetailBarang; $i++) {
                $ddb[] = [
                    'id_barang' => $idBarang,
                    'id_satuan' => $daftarSatuan[$i],
                    'kuantitas' => 0,
                    'turunan_id_satuan' => $daftarTurunan[$i],
                    'konversi_turunan' => $daftarKonversi[$i],
                ];
            }
            $bdb->insertBatch($ddb);
            if (!empty($bdb->errors())) {
                $this->delete($idBarang);
                $bool = FALSE;
            }
        } else {
            $bool = FALSE;
        }

        if ($bool) {
            return [
                'berhasil' => $bool,
            ];
        } else {
            return [
                'berhasil' => $bool,
                'pesan' => array_merge($this->errors(), $bdb->errors()),
            ];
        }
    }

    public function cariDetailBarangBerdasarkanIDBarang($idBarang)
    {
        return $this->query("
            SELECT db.id_detail_barang, brng.id_barang, brng.nama_barang, db.id_satuan, stn.nama_satuan, db.kuantitas, db.turunan_id_satuan, stnlain.nama_satuan AS nama_turunan_satuan, db.konversi_turunan 
            FROM detail_barang db
            JOIN barang brng ON brng.id_barang = db.id_barang 
            JOIN satuan stn ON stn.id_satuan = db.id_satuan 
            LEFT JOIN satuan stnlain ON stnlain.id_satuan = db.turunan_id_satuan
            WHERE db.id_barang = $idBarang 
            ORDER BY db.id_detail_barang ASC; 
        ")->getResultArray();
    }

    public function cariKuantitasBarangBerdasarkanIDBarangDanIDSatuan($idBarang, $idSatuan)
    {
        $detBarMod = new DetailBarangModel();
        $var = $detBarMod->select('kuantitas')
            ->where('id_barang', $idBarang)
            ->where('id_satuan', $idSatuan)
            ->first();

        return $var['kuantitas'];

        // return $this->query("
        //     SELECT db.kuantitas 
        //     FROM detail_barang db
        //     WHERE db.id_barang = $idBarang AND db.id_satuan = $idSatuan;
        // ")->getResultArray();
    }
}
