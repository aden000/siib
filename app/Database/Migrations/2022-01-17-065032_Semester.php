<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Semester extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_semester' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'semester_ke' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'tahun' => [
				'type' => 'VARCHAR',
				'constraint' => 4
			]
		]);
		$this->forge->addPrimaryKey('id_semester');
		$this->forge->createTable('semester');
	}

	public function down()
	{
		$this->forge->dropTable('semester');
	}
}
