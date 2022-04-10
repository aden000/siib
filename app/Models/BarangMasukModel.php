<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class BarangMasukModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'barang_masuk';
    protected $primaryKey       = 'id_barang_masuk';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user', 'id_semester', 'tanggal_masuk', 'id_vendor'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_user' => 'required|numeric',
        'id_semester' => 'required|numeric',
        'tanggal_masuk' => 'required',
        'id_vendor' => 'required|numeric'
    ];
    protected $validationMessages   = [
        'id_user' => [
            'required' => 'id user harus di isi',
            'numeric' => 'user ID harus berupa angka'
        ],
        'id_semester' => [
            'required' => 'id semester harus di isi',
            'numeric' => 'semester ID harus berupa angka'
        ],
        'id_vendor' => [
            'required' => 'kuantitas harus di isi',
            'numeric' => 'kuantitas harus berupa angka'
        ],
        'tanggal_masuk' => [
            'required' => 'tanggal masuk harus di isi'
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

    public function buatTambahBarangMasukDanDetailBarangMasuk(array $barangMasuk, array $barangList, array $satuanList, array $qtyList)
    {
        //asdas
        $bool = TRUE;
        // dd($barangMasuk, $satuanList, $qtyList);
        $detailBarangMasukModel = new DetailBarangMasukModel();
        $sess = \Config\Services::session();
        $this->insert([
            'id_user' => $sess->get('LoggedInID'),
            'id_semester' => $barangMasuk["idSemester"],
            'id_vendor' => $barangMasuk["idVendor"],
            'tanggal_masuk' => Time::now(),
        ]);
        if (empty($this->errors())) {
            $idBarangMasuk = $this->getInsertID();
            // $data = [];

            $cSL = count($satuanList);

            for ($i = 0; $i < $cSL; $i++) {
                $data = [
                    'id_barang_masuk' => $idBarangMasuk,
                    'id_barang' => $barangList[$i],
                    'kuantitas' => $qtyList[$i],
                    'id_satuan' => $satuanList[$i],
                ];
                $detailBarangMasukModel->insert($data);
            }
            // $detailBarangMasukModel->insertBatch($data);
            if (!empty($detailBarangMasukModel->errors())) {
                $this->delete($idBarangMasuk);
                $bool = FALSE;
            }
        } else {
            $bool = false;
        }
        if ($bool) {
            return [
                'berhasil' => $bool
            ];
        } else {
            return [
                'berhasil' => $bool,
                'pesan' => array_merge($this->errors(), $detailBarangMasukModel->errors()),
            ];
        }
    }

    public function cariBarangMasukByIDBarangDanTanggal($idBarang, $tglMasukAwal, $tglMasukAkhir)
    {
        $dbmModel = new DetailBarangMasukModel();
        $data = [];
        // $data['detail_barang_masuk'] = $dbmModel->join('barang', 'barang.id_barang = detail_barang_masuk.id_barang')
        //     ->join('satuan', 'satuan.id_satuan = detail_barang_masuk.id_satuan')
        //     ->join('barang_masuk', 'barang_masuk.id_barang_masuk = detail_barang_masuk.id_barang_masuk')
        //     ->where('detail_barang_masuk.id_barang', $idBarang)
        //     ->where("barang_masuk.tanggal_masuk BETWEEN '$tglMasukAwal' AND '$tglMasukAkhir'")
        //     ->findAll();

        $barMasList = $dbmModel->join('barang', 'barang.id_barang = detail_barang_masuk.id_barang')
            ->join('satuan', 'satuan.id_satuan = detail_barang_masuk.id_satuan')
            ->join('barang_masuk', 'barang_masuk.id_barang_masuk = detail_barang_masuk.id_barang_masuk')
            ->where('detail_barang_masuk.id_barang', $idBarang)
            ->where("barang_masuk.tanggal_masuk BETWEEN '$tglMasukAwal' AND '$tglMasukAkhir'")
            ->distinct()
            ->select('detail_barang_masuk.id_barang_masuk')
            ->findAll();

        if (!empty($barMasList)) {
            foreach ($barMasList as $barMas) {
                $data[] = [
                    'barang_masuk' => $this->join('semester', 'semester.id_semester = barang_masuk.id_semester')
                        ->join('users', 'users.id_user = barang_masuk.id_user')
                        ->join('vendor', 'vendor.id_vendor = barang_masuk.id_vendor')
                        ->find($barMas['id_barang_masuk']),
                    'detail_barang_masuk' => $dbmModel->join('barang', 'barang.id_barang = detail_barang_masuk.id_barang')
                        ->join('satuan', 'satuan.id_satuan = detail_barang_masuk.id_satuan')
                        ->join('barang_masuk', 'barang_masuk.id_barang_masuk = detail_barang_masuk.id_barang_masuk')
                        ->where('detail_barang_masuk.id_barang', $idBarang)
                        ->where('detail_barang_masuk.id_barang_masuk', $barMas['id_barang_masuk'])
                        ->where("barang_masuk.tanggal_masuk BETWEEN '$tglMasukAwal' AND '$tglMasukAkhir'")
                        ->findAll(),
                ];
                // $data['barang_masuk'][] = $this->join('semester', 'semester.id_semester = barang_masuk.id_semester')
                //     ->join('users', 'users.id_user = barang_masuk.id_user')
                //     ->find($barMas['id_barang_masuk']);

                // $data['detail_barang_masuk'][] = $dbmModel->join('barang', 'barang.id_barang = detail_barang_masuk.id_barang')
                //     ->join('satuan', 'satuan.id_satuan = detail_barang_masuk.id_satuan')
                //     ->join('barang_masuk', 'barang_masuk.id_barang_masuk = detail_barang_masuk.id_barang_masuk')
                //     ->where('detail_barang_masuk.id_barang', $idBarang)
                //     ->where('detail_barang_masuk.id_barang_masuk', $barMas['id_barang_masuk'])
                //     ->where("barang_masuk.tanggal_masuk BETWEEN '$tglMasukAwal' AND '$tglMasukAkhir'")
                //     ->findAll();
            }
        }
        return $data;
    }
}
