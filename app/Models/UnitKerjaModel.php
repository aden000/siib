<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitKerjaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'unit_kerja';
    protected $primaryKey       = 'id_unit_kerja';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_unit_kerja'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama_unit_kerja' => 'required'
    ];
    protected $validationMessages   = [
        'nama_unit_kerja' => [
            'required' => 'Nama unit kerja dibutuhkan'
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
