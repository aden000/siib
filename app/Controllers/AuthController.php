<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LogAktifitasModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\I18n\Time;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
	use ResponseTrait;
	public function login()
	{
		$uname = esc($this->request->getPost('uname'));
		$pword = esc($this->request->getPost('pword'));

		$model = new UserModel();
		$result = $model->where('username', $uname)->first();

		if (!is_null($result) && $result['username'] == $uname && password_verify($pword, $result['password'])) {
			if (!$this->request->getPost('android')) {
				$sess = session();
				$sess->set('LoggedInID', $result['id_user']);
				// $model->setDateLogin($result['id_user']);
				$sess->markAsTempdata('LoggedInID', 7200);
				// dd($result);

				//redirect user to dashboard
				$sebagai = '';
				if ($result['role'] == 1) $sebagai = 'PSI';
				if ($result['role'] == 2) $sebagai = 'Bagian Keuangan';
				if ($result['role'] == 3) $sebagai = 'Yayasan';
				if (!in_array($result['role'], [1, 2, 3])) $sebagai = 'Belum Terdefinisi';

				LogAktifitasModel::CreateLog(
					$result['id_user'],
					"Telah login pada "
						. Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
						. " Menggunakan " . $this->request->getUserAgent()->getBrowser()
				);

				return redirect()->route('admin.dashboard')->with('info', [
					'judul' => 'Selamat Datang!',
					'msg' => "" . $result['nama_user'] . " telah Login sebagai " . $sebagai,
					'role' => 'success'
				]);
			} else {
				$payload = [
					'id_user' => $result['id_user'],
					'nama_user' => $result['nama_user'],
					'role' => $result['role']
				];
				LogAktifitasModel::CreateLog(
					$result['id_user'],
					"Telah login pada "
						. Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
						. " Menggunakan Android "
				);
				return $this->respond([
					'jwt_token' => JWT::encode($payload, getenv('JWT_SECRET_KEY'), 'HS256'),
					'user_agent' => $this->request->getUserAgent()->getPlatform(),
				], 200);
			}
		} else {
			if ($this->request->getPost('android')) {
				return $this->failUnauthorized();
			} else {
				return redirect()->back()->with('info', [
					'judul' => 'Login Gagal',
					'msg' => 'Username atau password salah atau tidak ditemukan',
					'role' => 'error'
				]);
			}
		}
	}


	// public function loginAndroid(IncomingRequest $request)
	// {
	// 	$uname = esc($request->getPost('uname'));
	// 	$pword = esc($request->getPost('pword'));

	// 	$model = new UserModel();
	// 	$result = $model->where('username', $uname)->first();
	// 	if (!is_null($result) && $result['username'] == $uname && password_verify($pword, $result['password'])) {
	// 	} else {
	// 	}
	// }

	public function logout()
	{
		if (session()->get('LoggedInID')) {
			session()->remove('LoggedInID');
			return redirect()->route('home')->with('info', [
				'judul' => 'Logout Berhasil',
				'msg' => 'Terima Kasih',
				'role' => 'success'
			]);
		} else {
			return redirect()->route('home')->with('info', [
				'judul' => 'Logout Gagal',
				'msg' => 'Anda belum login',
				'role' => 'error'
			]);
		}
	}

	public function changePassword()
	{
		$oldPass = esc($this->request->getPost('oldpass'));
		$newPass = esc($this->request->getPost('newpass'));
		$newPassConfirm = esc($this->request->getPost('newpassconfirm'));
		if (empty($oldPass) || empty($newPass) || empty($newPassConfirm)) {
			if (!$this->request->getPost('android')) {
				return redirect()->back()->with('info', [
					'judul' => 'Semua isian harus di isi',
					'msg' => '',
					'role' => 'error'
				]);
			} else {
				return $this->fail('Mohon masukan semua field yang dibutuhkan');
			}
		}
		if ($newPass !== $newPassConfirm) {
			if (!$this->request->getPost('android')) {
				return redirect()->back()->with('info', [
					'judul' => 'Password dan Konfirmasi Password tidak sama',
					'msg' => 'Password yang anda masukan tidak sama dengan konfirmasi password',
					'role' => 'error'
				]);
			} else {
				return $this->fail('Password yang baru dan konfirmasi password tidak sama');
			}
		}

		$idUser = $this->userdata['id_user'];
		$uModel = new UserModel();
		$oldResult = $uModel->find($idUser);
		if (!password_verify($oldPass, $oldResult['password'])) {
			if (!$this->request->getPost('android')) {
				return redirect()->back()->with('info', [
					'judul' => 'Password saat ini yang anda masukan tidak valid',
					'msg' => 'Mohon masukan password saat ini yang valid',
					'role' => 'error'
				]);
			} else {
				return $this->fail('Password saat ini yang anda masukan tidak sesuai');
			}
		}
		if ($uModel->update($idUser, [
			'password' => password_hash($newPass, PASSWORD_BCRYPT)
		])) {
			LogAktifitasModel::CreateLog(
				$idUser,
				"Telah mengganti password secara mandiri pada tanggal "
					. Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
			);

			if (!$this->request->getPost('android')) {
				return redirect()->back()->with('info', [
					'judul' => 'Password Berhasil diubah',
					'msg' => 'Silahkan gunakan password yang baru',
					'role' => 'success'
				]);
			} else {
				return $this->respondUpdated([
					'message' => 'Sukses mengubah password'
				]);
			}
		} else {
			$err = $uModel->errors();
			if (!empty($err)) {
				$msgerr = '<ul>';
				foreach ($err as $e) {
					$msgerr .= '<li>' . esc($e) . '</li>';
				}
				$msgerr .= '</ul>';
				if (!$this->request->getPost('android')) {
					return redirect()->back()->with('info', [
						'judul' => 'Ubah password gagal',
						'msg' => $msgerr,
						'role' => 'error'
					]);
				} else {
					return $this->failValidationErrors($msgerr);
				}
			}
		}
	}
}
