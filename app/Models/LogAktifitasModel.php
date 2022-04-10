<?php

namespace App\Models;

use CodeIgniter\Model;

class LogAktifitasModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'log_aktifitas';
    protected $primaryKey       = 'id_log_aktifitas';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user', 'keterangan_aktifitas'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_user' => 'required',
        'keterangan_aktifitas' => 'required'
    ];
    protected $validationMessages   = [
        'id_user' => [
            'required' => 'Field ID User dibutuhkan',
        ],
        'keterangan_aktifitas' => [
            'required' => 'Field Keterangan Aktifitas harus diisi',
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
}
