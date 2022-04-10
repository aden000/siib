<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Detailbarangkeluar extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_detail_barang_keluar' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'id_barang_keluar' => [
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
			]
		]);
		$this->forge->addPrimaryKey('id_detail_barang_keluar');
		$this->forge->addForeignKey('id_barang_keluar', 'barang_keluar', 'id_barang_keluar');
		$this->forge->addForeignKey('id_barang', 'barang', 'id_barang');
		$this->forge->addForeignKey('id_satuan', 'satuan', 'id_satuan');
		$this->forge->createTable('detail_barang_keluar');
	}

	public function down()
	{
		$this->forge->dropTable('detail_barang_keluar');
	}
}
