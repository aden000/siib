<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use App\Models\BarangMasukModel;
use App\Models\BarangModel;
use App\Models\LogAktifitasModel;
use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;

class DefaultController extends BaseController
{
	public function index()
	{
		return view('Index', [
			"judul" => "Selamat Datang",

		]);
	}

	use ResponseTrait;
	public function dashboard()
	{
		$this->breadcrumbs[] = [
			'namelink' => 'Dashboard',
			'link' => base_url() . route_to('admin.dashboard')
		];

		$bModel = new BarangModel();
		$cB = count($bModel->findAll());

		$bmModel = new BarangMasukModel();
		$cBM = count($bmModel->findAll());

		$bkModel = new BarangKeluarModel();
		$cBK = count($bkModel->findAll());

		$logModel = new LogAktifitasModel();
		$AktifitasTerakhir = $logModel
			->join('users', 'log_aktifitas.id_user = users.id_user')
			->orderBy('id_log_aktifitas DESC')
			->select('*')
			->first();

		if (!$this->request->getPost('android'))
			return view('Admin/Index', [
				'judul' => 'Dashboard',
				'userdata' => $this->userdata,
				'breadcrumbs' => $this->breadcrumbs,
				'countBarang' => $cB,
				'countBarangMasuk' => $cBM,
				'countBarangKeluar' => $cBK,
				'AktifitasTerakhir' => $AktifitasTerakhir['nama_user'] . ': ' . substr($AktifitasTerakhir['keterangan_aktifitas'], 0, 60) . '...'
			]);
		else {
			return $this->respond([
				'dashboard_data' => [
					'countBarang' => $cB,
					'countBarangMasuk' => $cBM,
					'countBarangKeluar' => $cBK,
				],
			], 200);
		}
	}
	public function logAktifitas()
	{
		$this->breadcrumbs[] = [
			'namelink' => 'Log Aktifitas',
			'link' => base_url() . route_to('admin.logaktifitas')
		];

		$logModel = new LogAktifitasModel();
		$result = $logModel->join('users', 'users.id_user = log_aktifitas.id_user')
			->orderBy('id_log_aktifitas DESC')
			->findAll();

		return view('Admin/LogAktifitas', [
			'judul' => 'Log Aktifitas',
			'userdata' => $this->userdata,
			'breadcrumbs' => $this->breadcrumbs,
			'logList' => $result,
		]);
	}
}
