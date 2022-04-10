<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_satuan' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama_satuan' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ],
            'singkatan' => [
                'type' => 'VARCHAR',
                'constraint' => 5
            ]
        ]);
        $this->forge->addPrimaryKey('id_satuan');
        $this->forge->createTable('satuan');
    }

    public function down()
    {
        $this->forge->dropTable('satuan');
    }
}
