<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class KategoriBarangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kategori_barang';
    protected $primaryKey       = 'id_kategori_barang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_kategori_barang'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_kategori_barang' => 'required'
    ];
    protected $validationMessages   = [
        'nama_kategori_barang' => [
            'required' => 'Nama kategori barang dibutuhkan'
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

    protected function LogInsert(array $data)
    {
        $session = \Config\Services::session();

        $idLoggedIn = $session->get('LoggedInID');
        $logModel = new LogAktifitasModel();
        $logModel->insert([
            'id_user' => $idLoggedIn,
            'keterangan_aktifitas' => "Melakukan Penambahan Kategori Barang bernama \"" . $data['data']['nama_kategori_barang'] . "\" pada tanggal " . Time::now(),
        ]);

        return $data;
    }
    protected function LogUpdate_Pre(array $data)
    {
        $idKatBar_pre = $data['id'][0];
        $session = \Config\Services::session();

        $result = $this->find($idKatBar_pre);
        $session->set('LogUpdate_Pre', $result);

        return $data;
    }
    protected function LogUpdate_Post(array $data)
    {
        $session = \Config\Services::session();

        $idLoggedIn = $session->get('LoggedInID');
        $result = $session->get('LogUpdate_Pre');
        $session->remove('LogUpdate_Pre');

        $logModel = new LogAktifitasModel();
        $logModel->insert([
            'id_user' => $idLoggedIn,
            'keterangan_aktifitas' => "Melakukan Pengubahan Kategori Barang, sebelumnya bernama \"" . $result['nama_kategori_barang'] .  "\", sekarang bernama \"" . $data['data']['nama_kategori_barang'] . "\" pada tanggal " . Time::now(),
        ]);

        return $data;
    }
    protected function LogDelete_Pre(array $data)
    {
        $idKatBar_pre = $data['id'][0];
        $session = \Config\Services::session();

        $result = $this->find($idKatBar_pre);
        $session->set('LogDelete_Pre', $result);

        return $data;
    }
    protected function LogDelete_Post(array $data)
    {
        $session = \Config\Services::session();

        $idLoggedIn = $session->get('LoggedInID');
        $result = $session->get('LogDelete_Pre');
        $session->remove('LogDelete_Pre');
        // dd($result);

        $logModel = new LogAktifitasModel();
        $logModel->insert([
            'id_user' => $idLoggedIn,
            'keterangan_aktifitas' => "Melakukan Penghapusan Kategori Barang, sebelumnya bernama \"" . $result['nama_kategori_barang'] .  "\" pada tanggal " . Time::now(),
        ]);

        return $data;
    }
}
