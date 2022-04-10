<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barangkeluar extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_barang_keluar' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'id_unit_kerja' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'id_user' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'tanggal_keluar' => [
				'type' => 'DATETIME',
			],
			'status' => [
				'type' => 'VARCHAR',
				'constraint' => 50
			],
		]);
		$this->forge->addPrimaryKey('id_barang_keluar');
		$this->forge->addForeignKey(
			'id_unit_kerja',
			'unit_kerja',
			'id_unit_kerja'
		);
		$this->forge->addForeignKey(
			'id_user',
			'users',
			'id_user'
		);
		$this->forge->createTable('barang_keluar');
	}

	public function down()
	{
		$this->forge->dropTable('barang_keluar');
	}
}
