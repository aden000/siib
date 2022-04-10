<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Unitkerja extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_unit_kerja' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'nama_unit_kerja' => [
				'type' => 'VARCHAR',
				'constraint' => 50
			]
		]);
		$this->forge->addPrimaryKey('id_unit_kerja');
		$this->forge->createTable('unit_kerja');
	}

	public function down()
	{
		$this->forge->dropTable('unit_kerja');
	}
}
