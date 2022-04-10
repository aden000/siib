<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Logaktifitas extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_log_aktifitas' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'id_user' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'keterangan_aktifitas' => [
				'type' => 'TEXT'
			]
		]);
		$this->forge->addPrimaryKey('id_log_aktifitas');
		$this->forge->addForeignKey('id_user', 'users', 'id_user');
		$this->forge->createTable('log_aktifitas');
	}

	public function down()
	{
		$this->forge->dropTable('log_aktifitas');
	}
}
