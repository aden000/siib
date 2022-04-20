<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'DefaultController::index', ['as' => 'home']);
$routes->group('auth', function ($routes) {
	$routes->post('login', 'AuthController::login', ['as' => 'auth.login']);
	$routes->post('logout', 'AuthController::logout', ['as' => 'auth.logout']);
	$routes->post('changepass', 'AuthController::changePassword', ['as' => 'auth.changepass']);
});
$routes->group('api', function ($routes) {
	$routes->group('auth', function ($routes) {
		$routes->post('login', 'AuthController::login');
		$routes->post('logout', 'AuthController::logout');
		$routes->post('changepass', 'AuthController::changePassword');
	});
	$routes->post('user', 'UserController::getUserInfo', ['filter' => 'authfilter']);
	$routes->post('dashboard', 'DefaultController::dashboard', ['filter' => 'authfilter']);
	$routes->group('barang', ['filter' => 'authfilter'], function ($routes) {
		$routes->post('daftar-barang', 'TransaksiController::daftarBarang');
		$routes->post('keluar', 'TransaksiController::barangKeluar');
	});
});

$routes->group('admin', ['filter' => 'authfilter'], function ($routes) {
	$routes->get('dashboard', 'DefaultController::dashboard', ['as' => 'admin.dashboard']);
	$routes->group('users', ['filter' => 'authfilter:psi'], function ($routes) {
		$routes->get('/', 'UserController::manageUser', ['as' => 'admin.users.view']);
		$routes->post('create', 'UserController::createUser', ['as' => 'admin.users.create']);
		$routes->post('update', 'UserController::updateUser', ['as' => 'admin.users.update']);
		$routes->post('delete', 'UserController::deleteUser', ['as' => 'admin.users.delete']);
		$routes->post('resetpass', 'UserController::resetPasswordUser', ['as' => 'admin.users.resetpass']);
	});
	$routes->group('kelola', ['filter' => 'authfilter:psi,bagkeu'], function ($routes) {
		$routes->group('kategori-barang', function ($routes) {
			$routes->get('/', 'KelolaController::indexKategoriBarang', ['as' => 'admin.kelola.kategoribarang']);
			$routes->post('create', 'KelolaController::createKategoriBarang', ['as' => 'admin.kelola.kategoribarang.create']);
			$routes->post('update', 'KelolaController::updateKategoriBarang', ['as' => 'admin.kelola.kategoribarang.update']);
			$routes->post('delete', 'KelolaController::deleteKategoriBarang', ['as' => 'admin.kelola.kategoribarang.delete']);
		});
		$routes->group('unit-kerja', function ($routes) {
			$routes->get('/', 'KelolaController::indexUnitKerja', ['as' => 'admin.kelola.unitkerja']);
			$routes->post('create', 'KelolaController::createUnitKerja', ['as' => 'admin.kelola.unitkerja.create']);
			$routes->post('update', 'KelolaController::updateUnitKerja', ['as' => 'admin.kelola.unitkerja.update']);
			$routes->post('delete', 'KelolaController::deleteUnitKerja', ['as' => 'admin.kelola.unitkerja.delete']);
		});
		$routes->group('vendor', function ($routes) {
			$routes->get('/', 'KelolaController::indexVendor', ['as' => 'admin.kelola.vendor']);
			$routes->post('create', 'KelolaController::createVendor', ['as' => 'admin.kelola.vendor.create']);
			$routes->post('update', 'KelolaController::updateVendor', ['as' => 'admin.kelola.vendor.update']);
			$routes->post('delete', 'KelolaController::deleteVendor', ['as' => 'admin.kelola.vendor.delete']);
		});
		$routes->group('semester', function ($routes) {
			$routes->get('/', 'KelolaController::indexSemester', ['as' => 'admin.kelola.semester']);
			$routes->post('create', 'KelolaController::createSemester', ['as' => 'admin.kelola.semester.create']);
			$routes->post('update', 'KelolaController::updateSemester', ['as' => 'admin.kelola.semester.update']);
			$routes->post('delete', 'KelolaController::deleteSemester', ['as' => 'admin.kelola.semester.delete']);
		});
		$routes->group('satuan', function ($routes) {
			$routes->get('/', 'KelolaController::indexSatuan', ['as' => 'admin.kelola.satuan']);
			$routes->post('create', 'KelolaController::createSatuan', ['as' => 'admin.kelola.satuan.create']);
			$routes->post('update', 'KelolaController::updateSatuan', ['as' => 'admin.kelola.satuan.update']);
			$routes->post('delete', 'KelolaController::deleteSatuan', ['as' => 'admin.kelola.satuan.delete']);
		});
	});
	$routes->group('transaksi', ['filter' => 'authfilter:bagkeu'], function ($routes) {
		$routes->group('barang', function ($routes) {
			$routes->get('/', 'TransaksiController::daftarBarang', ['as' => 'admin.transaksi.barang']);
			$routes->get('tambah', 'TransaksiController::tambahBarang', ['as' => 'admin.transaksi.barang.tambah']);
			$routes->group('detail', function ($routes) {
				$routes->get('(:num)', 'TransaksiController::detailBarang/$1', ['as' => 'admin.transaksi.barang.detail']);
				$routes->post('create', 'TransaksiController::createDetailBarang', ['as' => 'admin.transaksi.barang.detail.create']);
				$routes->post('delete', 'TransaksiController::deleteDetailBarang', ['as' => 'admin.transaksi.barang.detail.delete']);
			});
			$routes->post('create', 'TransaksiController::createBarang', ['as' => 'admin.transaksi.barang.create']);
			$routes->post('update', 'TransaksiController::updateBarang', ['as' => 'admin.transaksi.barang.update']);
			$routes->post('delete', 'TransaksiController::deleteBarang', ['as' => 'admin.transaksi.barang.delete']);
			$routes->post('konversi', 'TransaksiController::konversiBarang', ['as' => 'admin.transaksi.barang.konversi']);
		});
		$routes->group('barang-masuk', function ($routes) {
			$routes->get('/', 'TransaksiController::barangMasuk', ['as' => 'admin.transaksi.barangmasuk']);
			$routes->get('tambah', 'TransaksiController::tambahBarangMasuk', ['as' => 'admin.transaksi.barangmasuk.tambah']);
			$routes->post('create', 'TransaksiController::createBarangMasuk', ['as' => 'admin.transaksi.barangmasuk.create']);
			$routes->get('detail/(:num)', 'TransaksiController::detailBarangMasuk/$1', ['as' => 'admin.transaksi.barangmasuk.detail']);
			$routes->get('detail/(:num)/pdf', 'PDFController::makePDFDetailBarangMasuk/$1', ['as' => 'admin.transaksi.barangmasuk.detail.pdf']);
		});
		$routes->group('barang-keluar', function ($routes) {
			$routes->get('/', 'TransaksiController::barangKeluar', ['as' => 'admin.transaksi.barangkeluar']);
			$routes->get('tambah', 'TransaksiController::barangKeluarForm', ['as' => 'admin.transaksi.barangkeluar.form']);
			$routes->post('create', 'TransaksiController::barangKeluarCreate', ['as' => 'admin.transaksi.barangkeluar.create']);
			$routes->get('detail/(:num)', 'TransaksiController::detailBarangKeluar/$1', ['as' => 'admin.transaksi.barangkeluar.detail']);
			$routes->get('detail/(:num)/pdf', 'PDFController::makePDFDetailBarangKeluar/$1', ['as' => 'admin.transaksi.barangkeluar.detail.pdf']);
			$routes->post('ubah-status', 'TransaksiController::ubahStatusBarangKeluar', ['as' => 'admin.transaksi.barangkeluar.ubahstatus']);
		});
	});
	$routes->post('ajax', 'AjaxController::pusatAjax', ['as' => 'admin.pusatajax']);
	$routes->group('pelaporan', ['filter' => 'authfilter:yayasan'], function ($routes) {
		$routes->get('/', 'PelaporanController::manajemenPelaporan', ['as' => 'admin.pelaporan']);
		$routes->post('referensi', 'PDFController::makePDFPelaporanReferensi', ['as' => 'admin.pelaporan.referensi']);
		$routes->post('barang', 'PDFController::makePDFPelaporanBarang', ['as' => 'admin.pelaporan.barang']);
		$routes->post('barang-masuk', 'PDFController::makePDFPelaporanBarangMasuk', ['as' => 'admin.pelaporan.barangmasuk']);
		$routes->post('barang-keluar', 'PDFController::makePDFPelaporanBarangKeluar', ['as' => 'admin.pelaporan.barangkeluar']);
	});
	$routes->get('log-aktifitas', 'DefaultController::logAktifitas', ['as' => 'admin.logaktifitas', 'filter' => 'authfilter:yayasan']);
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
