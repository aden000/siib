<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Vendor extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_vendor' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama_vendor' => [
                'type' => 'VARCHAR',
                'constraint' => 50
            ]
        ]);
        $this->forge->addPrimaryKey('id_vendor');
        $this->forge->createTable('vendor');
    }

    public function down()
    {
        $this->forge->dropTable('vendor');
    }
}
