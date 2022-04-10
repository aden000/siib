<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barangmasuk extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_barang_masuk' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'id_user' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'id_semester' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'id_vendor' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'tanggal_masuk' => [
				'type' => 'DATETIME',
			],
		]);
		$this->forge->addPrimaryKey('id_barang_masuk');
		$this->forge->addForeignKey(
			'id_user',
			'users',
			'id_user'
		);
		$this->forge->addForeignKey(
			'id_vendor',
			'vendor',
			'id_vendor'
		);
		$this->forge->addForeignKey(
			'id_semester',
			'semester',
			'id_semester'
		);
		$this->forge->createTable('barang_masuk');
	}

	public function down()
	{
		$this->forge->dropTable('barang_masuk');
	}
}
