<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Barang extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_barang' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'id_kategori_barang' => [
				'type' => 'INT',
				'unsigned' => true
			],
			'nama_barang' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			],
		]);
		$this->forge->addPrimaryKey('id_barang');
		$this->forge->addForeignKey('id_kategori_barang', 'kategori_barang', 'id_kategori_barang');
		$this->forge->createTable('barang');
	}

	public function down()
	{
		$this->forge->dropTable('barang');
	}
}
