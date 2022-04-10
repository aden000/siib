<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kategoribarang extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_kategori_barang' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			],
			'nama_kategori_barang' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			]
		]);
		$this->forge->addPrimaryKey('id_kategori_barang');
		$this->forge->createTable('kategori_barang');
	}

	public function down()
	{
		$this->forge->dropTable('kategori_barang');
	}
}
