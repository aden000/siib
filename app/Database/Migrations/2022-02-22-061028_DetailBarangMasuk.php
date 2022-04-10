<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailBarangMasuk extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_detail_barang_masuk' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'id_barang_masuk' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'id_barang' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'kuantitas' => [
                'type' => 'INT',
                'unsigned' => true
            ],
            'id_satuan' => [
                'type' => 'INT',
                'unsigned' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id_detail_barang_masuk');
        $this->forge->addForeignKey('id_barang_masuk', 'barang_masuk', 'id_barang_masuk');
        $this->forge->addForeignKey('id_satuan', 'satuan', 'id_satuan');
        $this->forge->addForeignKey('id_barang', 'barang', 'id_barang');
        $this->forge->createTable('detail_barang_masuk');
    }

    public function down()
    {
        $this->forge->dropTable('detail_barang_masuk');
    }
}
