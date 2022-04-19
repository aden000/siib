<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use App\Models\BarangMasukModel;
use App\Models\BarangModel;
use App\Models\DetailBarangKeluarModel;
use App\Models\DetailBarangMasukModel;
use App\Models\DetailBarangModel;
use App\Models\KategoriBarangModel;
use App\Models\LogAktifitasModel;
use App\Models\SatuanModel;
use App\Models\SemesterModel;
use App\Models\UnitKerjaModel;
use App\Models\VendorModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use DateTime;

class TransaksiController extends BaseController
{
    //Barang Section
    use ResponseTrait;
    public function daftarBarang()
    {
        $model = new BarangModel();
        $model = $model->join('kategori_barang', 'barang.id_kategori_barang = kategori_barang.id_kategori_barang')
            ->findAll();
        $kbModel = new KategoriBarangModel();
        $this->breadcrumbs[] = [
            'namelink' => 'Pengelolaan Barang',
            'link' => base_url() . route_to('admin.transaksi.barang')
        ];
        if (!$this->request->getPost('android'))
            return view('Admin/PengelolaanBarang', [
                'judul' => 'Pengelolaan Barang',
                'userdata' => $this->userdata,
                'baranglist' => $model,
                'katbarlist' => $kbModel->findAll(),
                'breadcrumbs' => $this->breadcrumbs,
            ]);
        else {
            return $this->respond([
                'barang' => $model
            ], 200);
        }
    }

    public function tambahBarang()
    {
        $katbarmodel = new KategoriBarangModel();
        $satuanmodel = new SatuanModel();
        $this->breadcrumbs[] = [
            'namelink' => 'Pengelolaan Barang',
            'link' => base_url() . route_to('admin.transaksi.barang')
        ];
        $this->breadcrumbs[] = [
            'namelink' => 'Tambah Barang',
            'link' => base_url() . route_to('admin.transaksi.barang.tambah')
        ];

        return view('Admin/TambahBarangForm', [
            'judul' => 'Tambah Barang',
            'userdata' => $this->userdata,
            'katbarlist' => $katbarmodel->findAll(),
            'satuanlist' => $satuanmodel->findAll(),
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }
    public function createBarang()
    {

        $idkatbar = esc($this->request->getPost('kategoribarang'));
        $satuanList = esc($this->request->getPost('satuan'));
        $turunanSatuanList = esc($this->request->getPost('turunansatuan'));
        $konversiTurunanSatuanList = esc($this->request->getPost('konvtursatuan'));
        $namaBarang = esc($this->request->getPost('namabarang'));

        if (empty($idkatbar) || empty($satuanList) || empty($turunanSatuanList) || empty($konversiTurunanSatuanList) || empty($namaBarang)) {
            return redirect()->route('admin.transaksi.barang.tambah')->with('info', [
                'judul' => 'Harap mengisi semua form',
                'msg' => 'Ada form yang tidak di isi, sehingga kami tidak dapat melanjutkan pemrosesan',
                'role' => 'error'
            ]);
        }

        $jumlahSatuanList = count($satuanList);
        $jumlahTurunanSatuanList = count($turunanSatuanList);
        $jumlahKonversiTurunanSatuanList = count($konversiTurunanSatuanList);

        if ($jumlahSatuanList <> $jumlahTurunanSatuanList || $jumlahTurunanSatuanList <> $jumlahKonversiTurunanSatuanList) {
            return redirect()->route('admin.transaksi.barang.tambah')->with('info', [
                'judul' => 'Harap mengisi semua form',
                'msg' => 'Ada form yang tidak di isi, sehingga kami tidak dapat melanjutkan pemrosesan',
                'role' => 'error'
            ]);
        }

        $dataBarang = [
            'nama_barang' => $namaBarang,
            'id_kategori_barang' => $idkatbar
        ];

        $barangModel = new BarangModel();

        //transaction begin, if below until transstatus is error, it will rollback,
        // else it will commited (Thankyou codeigniter 4!!! )
        $result = $barangModel->buatBarangBaruDanDetailBarang($dataBarang, $satuanList, $turunanSatuanList, $konversiTurunanSatuanList, $jumlahSatuanList);


        if ($result['berhasil']) {
            LogAktifitasModel::CreateLog(
                $this->userdata['id_user'],
                "Melakukan penambahan barang berupa " .
                    $namaBarang . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
            );
            return redirect()->route('admin.transaksi.barang')->with('info', [
                'judul' => 'Penambahan Barang Berhasil!',
                'msg' => 'Penambahan barang dan detail barang dilakukan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $errBar = $result['pesan'];
            $msgerr = '<ul>';
            foreach ($errBar as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            return redirect()->route('admin.transaksi.barang')->with('info', [
                'judul' => 'Pembuatan barang gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    public function updateBarang()
    {
        $idBarang = esc($this->request->getPost('idBarang'));
        $newNamaBarang = esc($this->request->getPost('namaBarang'));
        $newKatBar = esc($this->request->getPost('katbar'));

        $bModel = new BarangModel();
        $oldResult = $bModel->find($idBarang);
        if ($bModel->update($idBarang, [
            'id_kategori_barang' => $newKatBar,
            'nama_barang' => $newNamaBarang
        ])) {
            LogAktifitasModel::CreateLog(
                $this->userdata['id_user'],
                "Melakukan pengubahan barang dari " . $oldResult['nama_barang'] . ' Menjadi ' .
                    $newNamaBarang . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
            );
            return redirect()->route('admin.transaksi.barang')->with('info', [
                'judul' => 'Pengubahan Barang Berhasil!',
                'msg' => 'Pengubahan barang dilakukan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $err = $bModel->errors();
            if (!empty($err)) {
                $msgerr = '<ul>';
                foreach ($err as $e) {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
                $msgerr .= '</ul>';
                return redirect()->route('admin.transaksi.barang')->with('info', [
                    'judul' => 'Pengubahaan barang gagal',
                    'msg' => $msgerr,
                    'role' => 'error'
                ]);
            }
        }
    }

    public function detailBarang($idBarang)
    {
        if (empty($idBarang)) {
            return redirect()->route('admin.transaksi.barang')->with('info', [
                'judul' => 'Detail barang tidak ditemukan',
                'msg' => 'Detail barang tidak bisa ditampilkan',
                'role' => 'error'
            ]);
        }
        $model = new BarangModel();
        $resultB = $model->find($idBarang);
        $resultDB = $model->cariDetailBarangBerdasarkanIDBarang($idBarang);
        $sModel = new SatuanModel();

        // dd(empty($resultB), empty($resultDB));

        if (empty($resultDB) && empty($resultB)) {
            return redirect()->route('admin.transaksi.barang')->with('info', [
                'judul' => 'Detail barang tidak ditemukan',
                'msg' => 'Detail barang tidak bisa ditampilkan',
                'role' => 'error'
            ]);
        }

        $this->breadcrumbs[] = [
            'namelink' => 'Pengelolaan Barang',
            'link' => base_url() . route_to('admin.transaksi.barang')
        ];
        $this->breadcrumbs[] = [
            'namelink' => 'Detail Barang',
            'link' => '#'
        ];

        return view('Admin/DetailBarang', [
            'judul' => "Detail Barang",
            'subjudul' => $resultB['nama_barang'],
            'userdata' => $this->userdata,
            'breadcrumbs' => $this->breadcrumbs,
            'barang' => $resultB,
            'detailbaranglist' => $resultDB,
            'satuanlist' => $sModel->findAll(),
            'key' => $this->SetSessionAjaxReq()
        ]);
    }

    public function deleteBarang()
    {
        $idBarang = esc($this->request->getPost('idBarang'));

        $dbModel = new DetailBarangModel();
        $dbModel->hapusDetailBarangBerdasarkanIDBarang($idBarang);

        $bModel = new BarangModel();
        $oldResult = $bModel->find($idBarang);
        if ($bModel->delete($idBarang)) {
            LogAktifitasModel::CreateLog(
                $this->userdata['id_user'],
                "Melakukan penghapusan barang berupa " .
                    $oldResult['nama_barang'] . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
            );
            return redirect()->route('admin.transaksi.barang')->with('info', [
                'judul' => 'Penghapusan Barang Berhasil!',
                'msg' => 'Penghapusan barang dan detail barang dilakukan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $err = $bModel->errors();
            if (!empty($err)) {
                $msgerr = '<ul>';
                foreach ($err as $e) {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
                $msgerr .= '</ul>';
                return redirect()->route('admin.transaksi.barang')->with('info', [
                    'judul' => 'Penghapusan barang gagal',
                    'msg' => $msgerr,
                    'role' => 'error'
                ]);
            }
        }
    }

    public function konversiBarang()
    {
        // dd($this->request->getVar());
        $idBarang = esc($this->request->getPost('idBarangKonversi'));
        $idSatuan = esc($this->request->getPost('satuanBase'));
        $qtyExchange = esc($this->request->getPost('qtyExchange'));

        $dbModel = new DetailBarangModel();
        $bModel = new BarangModel();
        $result = $dbModel->ambilKuantitasDariAtasanSatuan($idBarang, $idSatuan, $qtyExchange);

        if ($result['success']) {
            // dd($result['qty']);
            LogAktifitasModel::CreateLog(
                $this->userdata['id_user'],
                "Melakukan pengkonversian kuantitas barang " . $bModel->find($idBarang)['nama_barang'] . " dari satuan atasan " . $result['qty']['namaSatuanAtasan'] . ' ke satuan dibawahnya yaitu ' .
                    $result['qty']['namaSatuanRepresentatif'] . ' dengan kuantitas dari atasan sebesar ' . $result['qty']['awalAtasan'] . ' Menjadi ' . $result['qty']['akhirAtasan'] .
                    ' dan menghasilkan konversi berikut ' . $result['qty']['awalRepresentatif'] . " + ($qtyExchange * " . $result['qty']['konversiTurunan'] . ") = " . $result['qty']['akhirRepresentatif'] .
                    " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
            );
            return redirect()->route('admin.transaksi.barang.detail', [$idBarang])->with('info', [
                'judul' => 'Pengkonversian Satuan Barang Berhasil!',
                'msg' => 'Pengkonversian Satuan barang dilakukan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            if (!empty($result['msg'])) {
                $msgerr = '<ul>';
                foreach ($result['msg'] as $e) {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
                $msgerr .= '</ul>';
                return redirect()->route('admin.transaksi.barang')->with('info', [
                    'judul' => 'Pengkonversian satuan barang gagal',
                    'msg' => $msgerr,
                    'role' => 'error'
                ]);
            }
        }
    }

    public function createDetailBarang()
    {
        $idBarang = esc($this->request->getPost('idBarang'));
        $satuan = esc($this->request->getPost('satuan'));
        $turunanSatuan = esc($this->request->getPost('turunanSatuan'));
        $konversiTurunan = esc($this->request->getPost('konversiTurunan'));

        $dbModel = new DetailBarangModel();
        if ($dbModel->insert([
            'id_barang' => $idBarang,
            'id_satuan' => $satuan,
            'turunan_id_satuan' => $turunanSatuan,
            'konversi_turunan' => $konversiTurunan,
            'kuantitas' => 0
        ])) {
            $bModel = new BarangModel();
            LogAktifitasModel::CreateLog(
                $this->userdata['id_user'],
                "Melakukan penambahan detail barang pada barang " .
                    $bModel->find($idBarang)['nama_barang'] . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
            );
            return redirect()->route('admin.transaksi.barang.detail', [$idBarang])->with('info', [
                'judul' => 'Penambahan Detail Barang Berhasil!',
                'msg' => 'Penambahan detail barang dilakukan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $err = $dbModel->errors();
            if (!empty($err)) {
                $msgerr = '<ul>';
                foreach ($err as $e) {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
                $msgerr .= '</ul>';
                return redirect()->route('admin.transaksi.barang.detail', [$idBarang])->with('info', [
                    'judul' => 'Penambahan detail barang gagal',
                    'msg' => $msgerr,
                    'role' => 'error'
                ]);
            }
        }
    }

    public function deleteDetailBarang()
    {
        $idDetailBarang = esc($this->request->getPost('idDetailBarang'));
        $idBarang = esc($this->request->getPost('idBarangDel'));

        $dbModel = new DetailBarangModel();
        $oldResult = $dbModel->join('satuan', 'satuan.id_satuan = detail_barang.id_satuan')->find($idDetailBarang);
        if ($dbModel->delete($idDetailBarang)) {
            $bModel = new BarangModel();
            LogAktifitasModel::CreateLog(
                $this->userdata['id_user'],
                "Melakukan penghapusan detail barang pada barang " . $bModel->find($idBarang)['nama_barang'] . " berupa " .
                    $oldResult['nama_satuan'] . " pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
            );
            return redirect()->route('admin.transaksi.barang.detail', [$idBarang])->with('info', [
                'judul' => 'Penghapusan Detail Barang Berhasil!',
                'msg' => 'Penghapusan detail barang dilakukan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $err = $dbModel->errors();
            if (!empty($err)) {
                $msgerr = '<ul>';
                foreach ($err as $e) {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
                $msgerr .= '</ul>';
                return redirect()->route('admin.transaksi.barang.detail', [$idBarang])->with('info', [
                    'judul' => 'Penghapusan detail barang gagal',
                    'msg' => $msgerr,
                    'role' => 'error'
                ]);
            }
        }
    }


    // Section Barang Masuk
    public function barangMasuk()
    {
        $bmModel = new BarangMasukModel();
        $bmModel = $bmModel->join('vendor', 'vendor.id_vendor = barang_masuk.id_vendor')
            ->join('users', 'users.id_user = barang_masuk.id_user')
            ->join('semester', 'semester.id_semester = barang_masuk.id_semester')
            ->select('barang_masuk.id_barang_masuk, users.nama_user, semester.semester_ke, semester.tahun, barang_masuk.tanggal_masuk, vendor.nama_vendor')
            ->orderBy('barang_masuk.tanggal_masuk DESC')
            ->findAll();
        $this->breadcrumbs[] = [
            'namelink' => 'Pengadaan Barang Masuk',
            'link' => base_url() . route_to('admin.transaksi.barangmasuk')
        ];
        return view('Admin/PengadaanBarangMasuk', [
            'judul' => 'Pengadaan Barang Masuk',
            'userdata' => $this->userdata,
            'bmlist' => $bmModel,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function tambahBarangMasuk()
    {
        $smtModel = new SemesterModel();
        $vendorModel = new VendorModel();
        $bModel = new BarangModel();
        $stuanModel = new SatuanModel();

        $this->breadcrumbs[] = [
            'namelink' => 'Pengadaan Barang Masuk',
            'link' => base_url() . route_to('admin.transaksi.barangmasuk')
        ];
        $this->breadcrumbs[] = [
            'namelink' => 'Tambah Barang Masuk',
            'link' => base_url() . route_to('admin.transaksi.barangmasuk.tambah')
        ];

        return view('Admin/TambahBarangMasukForm', [
            'judul' => 'Tambah Barang Masuk',
            'userdata' => $this->userdata,
            'blist' => $bModel->findAll(),
            'smtlist' => $smtModel->findAll(),
            'vlist' => $vendorModel->findAll(),
            'satuanlist' => $stuanModel->findAll(),
            'breadcrumbs' => $this->breadcrumbs,
            'key' => $this->SetSessionAjaxReq()
        ]);
    }

    public function createBarangMasuk()
    {

        $idSemester = esc($this->request->getPost('smtBrngTambah'));
        $idVendor = esc($this->request->getPost('vendorBrngTambah'));
        $barangList = esc($this->request->getPost('brngTambah'));
        $satuanList = esc($this->request->getPost('satuan'));
        $qtyList = esc($this->request->getPost('qty'));

        // dd($this->request->getVar());

        if (empty($idSemester) || empty($idVendor) || empty($barangList) || empty($satuanList) || empty($qtyList)) {
            return redirect()->route('admin.transaksi.barangmasuk.tambah')->with('info', [
                'judul' => 'Harap mengisi semua form',
                'msg' => 'Ada form yang tidak di isi, sehingga kami tidak dapat melanjutkan pemrosesan',
                'role' => 'error'
            ]);
        }
        $cSL = count($satuanList);
        $cQL = count($qtyList);
        $cBL = count($barangList);
        if ($cSL <> $cQL || $cQL <> $cBL) {
            return redirect()->route('admin.transaksi.barangmasuk.tambah')->with('info', [
                'judul' => 'Harap mengisi semua form',
                'msg' => 'Ada form yang tidak di isi, sehingga kami tidak dapat melanjutkan pemrosesan',
                'role' => 'error'
            ]);
        }

        $bmModel = new BarangMasukModel();
        $dataBarangMasuk = [
            'idSemester' => $idSemester,
            'idVendor' => $idVendor,
        ];

        $result = $bmModel->buatTambahBarangMasukDanDetailBarangMasuk($dataBarangMasuk, $barangList, $satuanList, $qtyList);
        if ($result['berhasil']) {
            LogAktifitasModel::CreateLog(
                $this->userdata['id_user'],
                "Melakukan penambahan barang masuk pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
            );
            return redirect()->route('admin.transaksi.barangmasuk')->with('info', [
                'judul' => 'Pengisian Barang Masuk Sukses!',
                'msg' => 'Penambahan Barang Masuk dapat diselesaikan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $errBar = $result['pesan'];
            $msgerr = '<ul>';
            foreach ($errBar as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            return redirect()->route('admin.transaksi.barangmasuk.tambah')->with('info', [
                'judul' => 'Pembuatan barang masuk gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    public function detailBarangMasuk($idBarangMasuk)
    {
        if (empty($idBarangMasuk)) {
            return redirect()->route('admin.transaksi.barangmasuk')->with('info', [
                'judul' => 'Detail Barang Masuk tidak ditemukan',
                'msg' => 'Detail Barang Masuk tidak bisa ditampilkan',
                'role' => 'error'
            ]);
        }

        $barMas = new BarangMasukModel();
        $detBarMas = new DetailBarangMasukModel();
        $barMas = $barMas->join('vendor', 'vendor.id_vendor = barang_masuk.id_vendor')
            ->join('semester', 'semester.id_semester = barang_masuk.id_semester')
            ->join('users', 'users.id_user = barang_masuk.id_user')
            ->find($idBarangMasuk);

        $dbmList = $detBarMas->join('barang', 'barang.id_barang = detail_barang_masuk.id_barang')
            ->join('satuan', 'satuan.id_satuan = detail_barang_masuk.id_satuan')
            ->where('id_barang_masuk', $idBarangMasuk)
            ->findAll();


        if (empty($dbmList) && empty($barMas)) {
            return redirect()->route('admin.transaksi.barangmasuk')->with('info', [
                'judul' => 'Detail Barang Masuk tidak ditemukan',
                'msg' => 'Detail Barang Masuk tidak bisa ditampilkan',
                'role' => 'error'
            ]);
        }

        $this->breadcrumbs[] = [
            'namelink' => 'Pengadaan Barang Masuk',
            'link' => base_url() . route_to('admin.transaksi.barangmasuk')
        ];
        $this->breadcrumbs[] = [
            'namelink' => 'Detail Barang Masuk',
            'link' => base_url() . route_to('admin.transaksi.barangmasuk.detail', $idBarangMasuk)
        ];

        return view('Admin/DetailPengadaanBarangMasuk', [
            'judul' => 'Detail Barang Masuk',
            'userdata' => $this->userdata,
            'breadcrumbs' => $this->breadcrumbs,
            'idBarMas' => $idBarangMasuk,
            'barMas' => $barMas,
            'dbmlist' => $dbmList
        ]);
    }

    public function barangKeluar()
    {
        $bklist = new BarangKeluarModel();
        $bklist = $bklist->join('unit_kerja', 'unit_kerja.id_unit_kerja = barang_keluar.id_unit_kerja')
            ->join('users', 'users.id_user = barang_keluar.id_user')
            ->select('barang_keluar.id_barang_keluar, unit_kerja.nama_unit_kerja, users.nama_user, barang_keluar.tanggal_keluar, barang_keluar.status')
            ->orderBy('barang_keluar.id_barang_keluar DESC')
            ->findAll();

        // dd($bklist);
        $this->breadcrumbs[] = [
            'namelink' => 'Pengajuan Barang Keluar',
            'link' => base_url() . route_to('admin.transaksi.barangkeluar')
        ];
        if (!$this->request->getPost('android'))
            return view('Admin/PengajuanBarangKeluar', [
                'judul' => 'Pengajuan Barang Keluar',
                'userdata' => $this->userdata,
                'bklist' => $bklist,
                'breadcrumbs' => $this->breadcrumbs,
            ]);
        else {
            return $this->respond([
                'barang_keluar' => $bklist
            ], 200);
        }
    }

    public function barangKeluarForm()
    {
        $blist = new BarangModel();
        $uklist = new UnitKerjaModel();

        $this->breadcrumbs[] = [
            'namelink' => 'Pengajuan Barang Keluar',
            'link' => base_url() . route_to('admin.transaksi.barangkeluar')
        ];
        $this->breadcrumbs[] = [
            'namelink' => 'Tambah Barang Keluar',
            'link' => base_url() . route_to('admin.transaksi.barangkeluar.form')
        ];

        return view('Admin/TambahBarangKeluarForm', [
            'judul' => 'Tambah Barang Keluar',
            'breadcrumbs' => $this->breadcrumbs,
            'userdata' => $this->userdata,
            'uklist' => $uklist->findAll(),
            'blist' => $blist->findAll(),
            'key' => $this->SetSessionAjaxReq()
        ]);
    }


    public function barangKeluarCreate()
    {

        $unitKerja = esc($this->request->getPost('unitKerja'));
        $bList = esc($this->request->getPost('brng'));
        $sList = esc($this->request->getPost('satuan'));
        $qList = esc($this->request->getPost('qty'));

        $bkModel = new BarangKeluarModel();

        if (empty($unitKerja) || empty($bList) || empty($sList) || empty($qList)) {
            return redirect()->route('admin.transaksi.barangkeluar')->withInput()->with('info', [
                'judul' => 'Tidak semua kolom di isi, Penambahan Barang Keluar gagal',
                'msg' => 'Harap mengisi keseluruhan kolom yang ada',
                'role' => 'error'
            ]);
        }
        $cBL = count($bList);
        $cSL = count($sList);
        $cQL = count($qList);

        if ($cBL <> $cSL || $cSL <> $cQL) {
            return redirect()->route('admin.transaksi.barangkeluar')->withInput()->with('info', [
                'judul' => 'Tidak semua kolom di isi, Penambahan Barang Keluar gagal',
                'msg' => 'Harap mengisi keseluruhan kolom yang ada',
                'role' => 'error'
            ]);
        }

        $barangKeluar = [
            'idUnitKerja' => $unitKerja,
            'Status' => 0
        ];
        $result = $bkModel->buatTambahBarangKeluarDanDetailBarangKeluar($barangKeluar, $bList, $sList, $qList);
        if ($result['berhasil']) {
            LogAktifitasModel::CreateLog(
                $this->userdata['id_user'],
                "Melakukan penambahan barang keluar pada tanggal " . Time::now()->toLocalizedString('d MMMM yyyy - HH:mm')
            );
            return redirect()->route('admin.transaksi.barangkeluar')->with('info', [
                'judul' => 'Pengisian Barang Keluar Sukses!',
                'msg' => 'Penambahan Barang Keluar dapat diselesaikan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $errBar = $result['pesan'];
            $msgerr = '<ul>';
            foreach ($errBar as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            return redirect()->route('admin.transaksi.barangkeluar.form')->with('info', [
                'judul' => 'Pembuatan Barang Keluar gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    public function detailBarangKeluar($idBarangKeluar)
    {
        if (empty($idBarangKeluar)) {
            return redirect()->route('admin.transaksi.barangkeluar')->with('info', [
                'judul' => 'Detail Barang Keluar tidak ditemukan',
                'msg' => 'Detail Barang Keluar tidak bisa ditampilkan',
                'role' => 'error'
            ]);
        }

        $barKel = new BarangKeluarModel();
        $detBarKel = new DetailBarangKeluarModel();
        $barKel = $barKel->join('unit_kerja', 'unit_kerja.id_unit_kerja = barang_keluar.id_unit_kerja')
            ->join('users', 'users.id_user = barang_keluar.id_user')
            ->find($idBarangKeluar);

        $dbmList = $detBarKel->join('barang', 'barang.id_barang = detail_barang_keluar.id_barang')
            ->join('satuan', 'satuan.id_satuan = detail_barang_keluar.id_satuan')
            ->where('id_barang_keluar', $idBarangKeluar)
            ->findAll();


        if (empty($dbmList) && empty($barKel)) {
            return redirect()->route('admin.transaksi.barangkeluar')->with('info', [
                'judul' => 'Detail Barang Keluar tidak ditemukan',
                'msg' => 'Detail Barang Keluar tidak bisa ditampilkan',
                'role' => 'error'
            ]);
        }

        $this->breadcrumbs[] = [
            'namelink' => 'Pengadaan Barang Keluar',
            'link' => base_url() . route_to('admin.transaksi.barangkeluar')
        ];
        $this->breadcrumbs[] = [
            'namelink' => 'Detail Barang Keluar',
            'link' => base_url() . route_to('admin.transaksi.barangkeluar.detail', $idBarangKeluar)
        ];

        return view('Admin/DetailPengajuanBarangKeluar', [
            'judul' => 'Detail Barang Keluar',
            'userdata' => $this->userdata,
            'breadcrumbs' => $this->breadcrumbs,
            'idBarKel' => $idBarangKeluar,
            'barKel' => $barKel,
            'dbklist' => $dbmList
        ]);
    }

    public function ubahStatusBarangKeluar()
    {
        $idBarKel = esc($this->request->getPost('idBarKel'));
        $barkelModel = new BarangKeluarModel();
        if ($barkelModel->update($idBarKel, [
            'status' => 1
        ])) {
            return redirect()->back()->with('info', [
                'judul' => 'Pengubahan Status Barang Keluar Berhasil!',
                'msg' => 'Ubah status barang keluar berjalan dengan sukses!',
                'role' => 'success'
            ]);
        } else {
            $err = $barkelModel->errors();
            if (!empty($err)) {
                $msgerr = '<ul>';
                foreach ($err as $e) {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
                $msgerr .= '</ul>';
                return redirect()->back()->with('info', [
                    'judul' => 'Pengubahan status barang keluar gagal',
                    'msg' => $msgerr,
                    'role' => 'error'
                ]);
            }
        }
    }
}
