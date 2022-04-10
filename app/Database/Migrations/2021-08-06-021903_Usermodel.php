<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Usermodel extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_user' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'nama_user' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			],
			'username' => [
				'type' => 'VARCHAR',
				'constraint' => 50,
			],
			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 100
			],
			'role' => [
				'type' => 'INT',
				'constraint' => 1
			],
			'created_at'	=> [
				'type'				=> 'DATETIME',
				'null'				=> true
			],
			'updated_at'	=> [
				'type'				=> 'DATETIME',
				'null'				=> true
			],
			'deleted_at'	=> [
				'type'				=> 'DATETIME',
				'null'				=> true
			]
		]);
		// $this->forge->addKey('id_user', true);
		// $this->forge->addKey('username', false, true);
		$this->forge->addPrimaryKey('id_user');
		$this->forge->addUniqueKey('username');

		$this->forge->createTable('users');
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}
