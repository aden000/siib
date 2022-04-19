<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktifitasModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Config\Services;

class UserController extends BaseController
{
	public function index()
	{
		//
	}
	public function manageUser()
	{
		$this->breadcrumbs[] = [
			'namelink' => 'Manajemen User',
			'link' => base_url() . route_to('admin.users.view'),
		];
		$uModel = new UserModel();
		return view('Admin/ManageUser', [
			'judul' => 'Manajemen User',
			'userdata' => $this->userdata,
			'userlist' => $uModel->findAll(),
			'breadcrumbs' => $this->breadcrumbs,
		]);
	}

	public function listUser()
	{
		if ($this->request->isAJAX()) {
			$request = Services::request();
			$datamodel = new UserModel($request);
			if ($request->getMethod() == 'post') {
				$lists = $datamodel->get_datatables();
				$data = [];
				$no = $request->getPost("start");
				foreach ($lists as $list) {
					$no++;
					$row = [];

					$row[] = $no;
					$row[] = $list->nama;
					$row[] = $list->username;
					$row[] = ($list->role == 0) ? 'Pusat Teknologi Informasi' : 'Biro Administrasi Umum';
					$row[] = '<a href="#" class="btn btn-success btn-sm"><i class="bi bi-info-circle"></i>&nbsp;Ubah Info</a>';

					$row[] = '';
					$data[] = $row;
				}
				$output = [
					"draw" => $request->getPost('draw'),
					"recordsTotal" => $datamodel->count_all(),
					"recordsFiltered" => $datamodel->count_filtered(),
					"data" => $data
				];
				return json_encode($output);
			}
		}
	}

	public function createUser()
	{
		$nama_user = esc($this->request->getPost('nama'));
		$username = esc($this->request->getPost('uname'));
		$password = esc($this->request->getPost('pword'));
		$konfpassword = esc($this->request->getPost('kpword'));
		$role = esc($this->request->getPost('role'));

		if ($konfpassword !== $password) {
			return redirect()->route('admin.users.view')->withInput()->with('info', [
				'judul' => 'Password dan Konfirmasi Password tidak sama',
				'msg' => 'Harap samakan isian password dan konfirmasi password',
				'role' => 'error'
			]);
		}

		$uModel = new UserModel();
		if ($uModel->insert([
			'nama_user' => $nama_user,
			'username' => $username,
			'password' => password_hash($password, PASSWORD_BCRYPT),
			'role' => $role
		])) {
			LogAktifitasModel::CreateLog(
				$this->userdata['id_user'],
				"Melakukan penambahan user berupa " .
					$nama_user . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
			);
			return redirect()->route('admin.users.view')->with('info', [
				'judul' => 'Pembuatan User Berhasil',
				'msg' => 'Pembuatan user beserta hak akses sukses!',
				'role' => 'success'
			]);
		} else {
			$err = $uModel->errors();
			if (!empty($err)) {
				$msgerr = '<ul>';
				foreach ($err as $e) {
					$msgerr .= '<li>' . esc($e) . '</li>';
				}
				$msgerr .= '</ul>';
				return redirect()->route('admin.users.view')->withInput()->with('info', [
					'judul' => 'Pembuatan user gagal',
					'msg' => $msgerr,
					'role' => 'error'
				]);
			}
		}
	}

	public function updateUser()
	{
		$idUser = esc($this->request->getPost('editIdUser'));
		$editNama = esc($this->request->getPost('editNama'));
		$username = esc($this->request->getPost('editUserName'));
		$role = esc($this->request->getPost('role'));

		$uModel = new UserModel();
		$oldResult = $uModel->find($idUser);
		if ($uModel->update($idUser, [
			'nama_user' => $editNama,
			'username' => $username,
			'role' => $role
		])) {
			LogAktifitasModel::CreateLog(
				$this->userdata['id_user'],
				"Melakukan pengubahan user pada " .
					$oldResult['nama_user'] . " Menjadi " . $editNama . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
			);
			return redirect()->route('admin.users.view')->with('info', [
				'judul' => 'Pengubahan User Berhasil',
				'msg' => 'Pengubahan user sukses!',
				'role' => 'success'
			]);
		} else {
			$err = $uModel->errors();
			if (!empty($err)) {
				$msgerr = '<ul>';
				foreach ($err as $e) {
					$msgerr .= '<li>' . esc($e) . '</li>';
				}
				$msgerr .= '</ul>';
				return redirect()->route('admin.users.view')->with('info', [
					'judul' => 'Pengubahan user gagal',
					'msg' => $msgerr,
					'role' => 'error'
				]);
			}
		}
	}

	public function deleteUser()
	{
		$idUser = esc($this->request->getPost('delIdUser'));
		$uModel = new UserModel();
		$oldResult = $uModel->find($idUser);
		if ($uModel->delete($idUser)) {
			LogAktifitasModel::CreateLog(
				$this->userdata['id_user'],
				"Melakukan penghapusan user dengan nama " .
					$oldResult['nama_user'] . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
			);
			return redirect()->route('admin.users.view')->with('info', [
				'judul' => 'Penghapusan User Berhasil',
				'msg' => 'Penghapusan user sukses!',
				'role' => 'success'
			]);
		} else {
			$err = $uModel->errors();
			if (!empty($err)) {
				$msgerr = '<ul>';
				foreach ($err as $e) {
					$msgerr .= '<li>' . esc($e) . '</li>';
				}
				$msgerr .= '</ul>';
				return redirect()->route('admin.users.view')->with('info', [
					'judul' => 'Penghapusan user gagal',
					'msg' => $msgerr,
					'role' => 'error'
				]);
			}
		}
	}

	public function resetPasswordUser()
	{
		$idUser = esc($this->request->getPost('resetPassIdUser'));
		$uModel = new UserModel();
		$oldResult = $uModel->find($idUser);
		if ($uModel->update($idUser, [
			'password' => password_hash(getenv('RESET_PASSWORD_VALUE_DEFAULT'), PASSWORD_BCRYPT)
		])) {
			LogAktifitasModel::CreateLog(
				$this->userdata['id_user'],
				"Melakukan pengubahan password untuk user " .
					$oldResult['nama_result'] . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
			);
			return redirect()->route('admin.users.view')->with('info', [
				'judul' => 'Reset Password User Berhasil',
				'msg' => 'Reset password user sukses!',
				'role' => 'success'
			]);
		} else {
			$err = $uModel->errors();
			if (!empty($err)) {
				$msgerr = '<ul>';
				foreach ($err as $e) {
					$msgerr .= '<li>' . esc($e) . '</li>';
				}
				$msgerr .= '</ul>';
				return redirect()->route('admin.users.view')->with('info', [
					'judul' => 'Reset password user gagal',
					'msg' => $msgerr,
					'role' => 'error'
				]);
			}
		}
	}

	use ResponseTrait;
	public function getUserInfo()
	{
		// $this->request->header('Authorization');
		// $token = '';
		// if (!empty($header)) {
		// 	if (preg_match('/Bearer\s(\S+)/', $header, $matches)) {
		// 		$token = $matches[1];
		// 	}
		// }

		// $payload = explode('.', $token);
		// $payload = json_decode(utf8_decode(base64_decode($payload[1])));

		$id_user = esc($this->request->getPost('id_user'));

		$uModel = new UserModel();
		return $this->respond([
			// 'token' => $token,
			'userdata' => $uModel->find($id_user),
		], 200);
	}
}
