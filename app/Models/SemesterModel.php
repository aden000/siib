<?php

namespace App\Models;

use CodeIgniter\Model;

class SemesterModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'semester';
    protected $primaryKey       = 'id_semester';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'semester_ke', 'tahun'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'semester_ke' => 'required|min_length[1]|in_list[1,2]',
        'tahun' => 'required|min_length[4]|numeric'
    ];
    protected $validationMessages   = [
        'semester_ke' => [
            'required' => 'Field semester dibutuhkan',
            'min_length' => 'Minimal panjang karakter yang dibolehkan hanya 1 karakter',
            'in_list' => 'Nilai yang dibolehkan hanya 1 dan 2',
        ],
        'tahun' => [
            'required' => 'Field tahun dibutuhkan',
            'min_length' => 'Minimal panjang karakter yang dibolehkan hanya 4 karakter',
            'numeric' => 'Harus berupa angka'
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
