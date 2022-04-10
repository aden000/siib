<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailBarang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail_barang' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_barang' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'id_satuan' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'kuantitas' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'turunan_id_satuan' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'konversi_turunan' => [
                'type' => 'INT',
                'unsigned' => true
            ]
        ]);
        $this->forge->addPrimaryKey('id_detail_barang');
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang');
        $this->forge->addForeignKey('id_satuan', 'satuan', 'id_satuan');
        $this->forge->createTable('detail_barang');
    }

    public function down()
    {
        $this->forge->dropTable('detail_barang');
    }
}
