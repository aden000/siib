<?php

namespace App\Database\Seeds;

use App\Models\UserModel;
use CodeIgniter\Database\Seeder;

class Userseed extends Seeder
{
	public function run()
	{
		$model = new UserModel();
		$model->insert([
			'nama_user' => 'Administrator PSI',
			'username' => 'admin',
			'password' => password_hash('admin', PASSWORD_BCRYPT),
			'role' => 0 //ACCESS PSI, 1 = ACCESS BAG. KEUANGAN, 2, Yayasan
		]);
		// $data = [
		// 	'nama_user' => 'Administrator PSI',
		// 	'username' => 'admin',
		// 	'password' => password_hash('admin', PASSWORD_BCRYPT),
		// 	'role' => 0
		// ];
		// $this->db->table('users')->insert($data);	
	}
}
