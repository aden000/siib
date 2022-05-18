<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class BarangKeluarModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'barang_keluar';
    protected $primaryKey       = 'id_barang_keluar';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_unit_kerja', 'id_user', 'tanggal_keluar', 'status'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_unit_kerja' => 'required|numeric',
        'id_user' => 'required|numeric',
        'tanggal_keluar' => 'required',
        'status' => 'required'
    ];
    protected $validationMessages   = [
        'id_unit_kerja' => [
            'required' => 'Unit Kerja harus di isi',
            'numeric' => 'Input untuk "unit kerja" tidak sesuai kriteria'
        ],
        'id_user' => [
            'required' => 'User harus di isi',
            'numeric' => 'Input untuk "id_user" tidak sesuai kriteria'
        ],
        'tanggal_keluar' => [
            'required' => 'Tanggal Keluar harus di isi',
        ],
        'status' => [
            'required' => 'Status harus di isi'
        ]
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

    public function cariDetailBarangKeluarBerdasarkanIDBarangKeluar($id)
    {
        $dbklist = new DetailBarangKeluarModel();
        $dbklist = $dbklist->join('barang_keluar', 'barang_keluar.id_barang_keluar = detail_barang_keluar.id_barang_keluar')
            ->join('barang', 'barang.id_barang', 'detail_barang_keluar.id_barang')
            ->where('detail_barang_keluar.id_barang_keluar', $id)
            ->findAll();

        return $dbklist;
    }

    public function buatTambahBarangKeluarDanDetailBarangKeluar(int $idUser, array $barangKeluar, array $bList, array $sList, array $qList)
    {
        $bool = TRUE;
        // dd($barangMasuk, $satuanList, $qtyList);
        $dbkModel = new DetailBarangKeluarModel();
        // $sess = \Config\Services::session();
        $this->insert([
            'id_user' => $idUser, //$sess->get('LoggedInID'),
            'id_unit_kerja' => $barangKeluar["idUnitKerja"],
            'tanggal_keluar' => Time::now(),
            'status' => $barangKeluar['Status']
        ]);
        if (empty($this->errors())) {
            $idBarangKeluar = $this->getInsertID();
            // $data = [];

            $cSL = count($sList);

            for ($i = 0; $i < $cSL; $i++) {
                $data = [
                    'id_barang_keluar' => $idBarangKeluar,
                    'id_barang' => $bList[$i],
                    'kuantitas' => $qList[$i],
                    'id_satuan' => $sList[$i],
                ];
                $dbkModel->insert($data);
            }
            // $dbkModel->insertBatch($data);
            if (!empty($dbkModel->errors())) {
                $this->delete($idBarangKeluar);
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
                'pesan' => array_merge($this->errors(), $dbkModel->errors()),
            ];
        }
    }

    public function cariBarangKeluarByIDBarangDanTanggal($idBarang, $tglKeluarAwal, $tglKeluarAkhir)
    {
        $dbkModel = new DetailBarangKeluarModel();
        $data = [];
        // $data['detail_barang_masuk'] = $dbmModel->join('barang', 'barang.id_barang = detail_barang_masuk.id_barang')
        //     ->join('satuan', 'satuan.id_satuan = detail_barang_masuk.id_satuan')
        //     ->join('barang_masuk', 'barang_masuk.id_barang_masuk = detail_barang_masuk.id_barang_masuk')
        //     ->where('detail_barang_masuk.id_barang', $idBarang)
        //     ->where("barang_masuk.tanggal_masuk BETWEEN '$tglMasukAwal' AND '$tglMasukAkhir'")
        //     ->findAll();

        $barKelList = $dbkModel->join('barang', 'barang.id_barang = detail_barang_keluar.id_barang')
            ->join('satuan', 'satuan.id_satuan = detail_barang_keluar.id_satuan')
            ->join('barang_keluar', 'barang_keluar.id_barang_keluar = detail_barang_keluar.id_barang_keluar')
            ->where('detail_barang_keluar.id_barang', $idBarang)
            ->where("barang_keluar.tanggal_keluar BETWEEN '$tglKeluarAwal' AND '$tglKeluarAkhir'")
            ->distinct()
            ->select('detail_barang_keluar.id_barang_keluar')
            ->findAll();

        if (!empty($barKelList)) {
            foreach ($barKelList as $barKel) {
                $data[] = [
                    'barang_keluar' => $this->join('users', 'users.id_user = barang_keluar.id_user')
                        ->join('unit_kerja', 'unit_kerja.id_unit_kerja = barang_keluar.id_unit_kerja')
                        ->find($barKel['id_barang_keluar']),
                    'detail_barang_keluar' => $dbkModel->join('barang', 'barang.id_barang = detail_barang_keluar.id_barang')
                        ->join('satuan', 'satuan.id_satuan = detail_barang_keluar.id_satuan')
                        ->join('barang_keluar', 'barang_keluar.id_barang_keluar = detail_barang_keluar.id_barang_keluar')
                        ->where('detail_barang_keluar.id_barang', $idBarang)
                        ->where('detail_barang_keluar.id_barang_keluar', $barKel['id_barang_keluar'])
                        ->where("barang_keluar.tanggal_keluar BETWEEN '$tglKeluarAwal' AND '$tglKeluarAkhir'")
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
