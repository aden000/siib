<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangKeluarModel;
use App\Models\BarangMasukModel;
use App\Models\BarangModel;
use App\Models\DetailBarangKeluarModel;
use App\Models\DetailBarangMasukModel;
use App\Models\KategoriBarangModel;
use App\Models\SatuanModel;
use App\Models\SemesterModel;
use App\Models\UnitKerjaModel;
use App\Models\VendorModel;
use CodeIgniter\I18n\Time;
use Dompdf\Dompdf;

class PDFController extends BaseController
{
    public function makePDFDetailBarangMasuk($idBarangMasuk)
    {
        if (empty($idBarangMasuk)) {
            return redirect('admin.transaksi.barangmasuk')->with('info', [
                'judul' => 'ID Barang tidak ditemukan',
                'msg' => 'harap masukan id barang',
                'role' => 'error'
            ]);
        }
        $bmModel = new BarangMasukModel();
        $bmList = $bmModel->join('vendor', 'vendor.id_vendor = barang_masuk.id_vendor')
            ->join('semester', 'semester.id_semester = barang_masuk.id_semester')
            ->join('users', 'users.id_user = barang_masuk.id_user')
            ->find($idBarangMasuk);

        $dbmModel = new DetailBarangMasukModel();
        $dbmList = $dbmModel->join('barang', 'barang.id_barang = detail_barang_masuk.id_barang')
            ->join('satuan', 'satuan.id_satuan = detail_barang_masuk.id_satuan')
            ->where('id_barang_masuk', $idBarangMasuk)
            ->findAll();

        if (empty($bmList) && empty($dbmList)) {
            return redirect('admin.transaksi.barangmasuk')->with('info', [
                'judul' => 'ID Barang tidak ditemukan',
                'msg' => 'harap masukan id barang',
                'role' => 'error'
            ]);
        }

        helper('inflector');
        $pdf = new Dompdf([
            'enable_remote' => true,
        ]);
        $pdf->setPaper('A4');
        $pdf->loadHtml(view('Admin/PDF/DetailBarangMasuk', [
            'data' => [
                'nama_user' => $bmList['nama_user'],
                'tanggal_masuk' => $bmList['tanggal_masuk'],
                'nama_vendor' => $bmList['nama_vendor']
            ],
            'daftarBarangMasuk' => $dbmList,
        ]));

        $pdf->render();
        $pdf->stream('BarangMasuk_' . pascalize($bmList['nama_vendor']) . '_' . $bmList['tanggal_masuk'] . '.pdf', ['Attachment' => 0]);
        die();
    }

    public function makePDFDetailBarangKeluar($idBarangKeluar)
    {
        if (empty($idBarangKeluar)) {
            return redirect('admin.transaksi.barangkeluar')->with('info', [
                'judul' => 'ID Barang tidak ditemukan',
                'msg' => 'harap masukan id barang',
                'role' => 'error'
            ]);
        }

        $bkModel = new BarangKeluarModel();
        $bkList = $bkModel->join('unit_kerja', 'unit_kerja.id_unit_kerja = barang_keluar.id_unit_kerja')
            ->join('users', 'users.id_user = barang_keluar.id_user')
            ->find($idBarangKeluar);

        $dbkModel = new DetailBarangKeluarModel();
        $dbkList = $dbkModel->join('barang', 'barang.id_barang = detail_barang_keluar.id_barang')
            ->join('satuan', 'satuan.id_satuan = detail_barang_keluar.id_satuan')
            ->where('id_barang_keluar', $idBarangKeluar)
            ->findAll();

        if (empty($bkList) && empty($dbkList)) {
            return redirect('admin.transaksi.barangkeluar')->with('info', [
                'judul' => 'ID Barang tidak ditemukan',
                'msg' => 'harap masukan id barang',
                'role' => 'error'
            ]);
        }

        helper('inflector');
        $pdf = new Dompdf([
            'enable_remote' => true,
        ]);
        $pdf->setPaper('A4');
        $pdf->loadHtml(view('Admin/PDF/DetailBarangKeluar', [
            'data' => [
                'nama_user' => $bkList['nama_user'],
                'tanggal_keluar' => $bkList['tanggal_keluar'],
                'nama_unit_kerja' => $bkList['nama_unit_kerja'],
                'status' => $bkList['status']
            ],
            'daftarBarangKeluar' => $dbkList,
        ]));

        $pdf->render();
        $pdf->stream('BarangKeluar_' . pascalize($bkList['nama_unit_kerja']) . '_' . $bkList['tanggal_keluar'] . '.pdf', ['Attachment' => 0]);
        die();
    }

    public function makePDFPelaporanReferensi()
    {
        $referensi = esc($this->request->getPost('referensi'));

        $data = [];
        foreach ($referensi as $ref) {
            if ('1' == $ref) {
                $katBar = new KategoriBarangModel();
                $data[] = [
                    'nama_referensi' => 'Kategori Barang',
                    'data' => $katBar->findAll(),
                    'ref' => $ref
                ];
            }
            if ('2' == $ref) {
                $unitKerja = new UnitKerjaModel();
                $data[] = [
                    'nama_referensi' => 'Unit Kerja',
                    'data' => $unitKerja->findAll(),
                    'ref' => $ref
                ];
            }
            if ('3' == $ref) {
                $vendor = new VendorModel();
                $data[] = [
                    'nama_referensi' => 'Vendor / Perusahaan',
                    'data' => $vendor->findAll(),
                    'ref' => $ref
                ];
            }
            if ('4' == $ref) {
                $semester = new SemesterModel();
                $data[] = [
                    'nama_referensi' => 'Semester',
                    'data' => $semester->findAll(),
                    'ref' => $ref
                ];
            }
            if ('5' == $ref) {
                $satuan = new SatuanModel();
                $data[] = [
                    'nama_referensi' => 'Satuan',
                    'data' => $satuan->findAll(),
                    'ref' => $ref
                ];
            }
        }

        $pdf = new Dompdf([
            'enable_remote' => true,
        ]);
        $pdf->setPaper('A4');
        $pdf->loadHtml(view('Admin/PDF/PelaporanReferensi', [
            'data' => $data,
        ]));
        $pdf->render();
        $pdf->stream('PelaporanReferensi.pdf', [
            'Attachment' => 0,
            'compress' => 0
        ]);
        die(); //U need to DIE THIS PROCESS AFTER STREAM THIS, HUH HOW MANY HOURS I GET THIS...
    }

    public function makePDFPelaporanBarang()
    {
        $bList = esc($this->request->getPost('barang'));
        $bModel = new BarangModel();

        $data = [];
        foreach ($bList as $b) {
            $data[] = [
                'barang' => $bModel->find($b),
                'detail_barang' => $bModel->cariDetailBarangBerdasarkanIDBarang($b),
            ];
        }

        $pdf = new Dompdf([
            'enable_remote' => true,
        ]);
        $pdf->setPaper('A4');
        $pdf->loadHtml(view('Admin/PDF/PelaporanBarang', [
            'data' => $data,
        ]));
        $pdf->render();
        $pdf->stream("PelaporanBarang.pdf", [
            'Attachment' => 0,
            'compress' => 0
        ]);
        die(); //U need to DIE THIS PROCESS AFTER STREAM THIS, HUH HOW MANY HOURS I GET THIS... WHY!
    }

    public function makePDFPelaporanBarangMasuk()
    {
        $idBarang = esc($this->request->getPost('barang'));
        $tglMasukAwal = esc($this->request->getPost('fromBarangMasuk'));
        $tglMasukAkhir = esc($this->request->getPost('toBarangMasuk'));

        $tglMasukAwal = new Time($tglMasukAwal);
        $tglMasukAwal->toDateTimeString();
        $tglMasukAkhir = new Time($tglMasukAkhir);
        if ($tglMasukAwal == $tglMasukAkhir) $tglMasukAkhir = $tglMasukAkhir->addHours(23)->addMinutes(59)->addSeconds(59);
        $tglMasukAkhir->toDateTimeString();

        $bmModel = new BarangMasukModel();
        $data = $bmModel->cariBarangMasukByIDBarangDanTanggal($idBarang, $tglMasukAwal, $tglMasukAkhir);

        if (empty($data)) {
            $bModel = new BarangModel();
            $bModel = $bModel->find($idBarang);
            return redirect()->back()->with('info', [
                'judul' => 'Tidak ada data',
                'msg' => 'Tidak ada data barang ' . $bModel['nama_barang'] .  ' pada tanggal antara ' . Time::parse($tglMasukAwal)->toLocalizedString("d-MMMM-yyyy") . ' - ' . Time::parse($tglMasukAkhir)->toLocalizedString("d-MMMM-yyyy"),
                'role' => 'error'
            ]);
        }
        // dd($data);

        $pdf = new Dompdf([
            'enable_remote' => true,
        ]);
        $pdf->setPaper('A4');
        $pdf->loadHtml(view('Admin/PDF/PelaporanBarangMasuk', [
            'data' => $data,
            'tglMasukAwal' => $tglMasukAwal,
            'tglMasukAkhir' => $tglMasukAkhir
        ]));
        $pdf->render();
        $pdf->stream("PelaporanBarangMasuk.pdf", [
            'Attachment' => 0,
            'compress' => 0
        ]);
        die();
    }

    public function makePDFPelaporanBarangKeluar()
    {
        $idBarang = esc($this->request->getPost('barang'));
        $tglKeluarAwal = esc($this->request->getPost('fromBarangKeluar'));
        $tglKeluarAkhir = esc($this->request->getPost('toBarangKeluar'));

        $tglKeluarAwal = new Time($tglKeluarAwal);
        $tglKeluarAwal->toDateTimeString();
        $tglKeluarAkhir = new Time($tglKeluarAkhir);
        if ($tglKeluarAwal == $tglKeluarAkhir) $tglKeluarAkhir = $tglKeluarAkhir->addHours(23)->addMinutes(59)->addSeconds(59);
        $tglKeluarAkhir->toDateTimeString();

        $bkModel = new BarangKeluarModel();
        $data = $bkModel->cariBarangKeluarByIDBarangDanTanggal($idBarang, $tglKeluarAwal, $tglKeluarAkhir);
        if (empty($data)) {
            $bModel = new BarangModel();
            $bModel = $bModel->find($idBarang);
            return redirect()->back()->with('info', [
                'judul' => 'Tidak ada data',
                'msg' => 'Tidak ada data barang ' . $bModel['nama_barang'] .  ' pada tanggal antara ' . Time::parse($tglKeluarAwal)->toLocalizedString("d-MMMM-yyyy") . ' - ' . Time::parse($tglKeluarAkhir)->toLocalizedString("d-MMMM-yyyy"),
                'role' => 'error'
            ]);
        }

        $pdf = new Dompdf([
            'enable_remote' => true,
        ]);
        $pdf->setPaper('A4');
        $pdf->loadHtml(view('Admin/PDF/PelaporanBarangKeluar', [
            'data' => $data,
            'tglKeluarAwal' => $tglKeluarAwal,
            'tglKeluarAkhir' => $tglKeluarAkhir
        ]));
        $pdf->render();
        $pdf->stream("PelaporanBarangKeluar_" . Time::parse($tglKeluarAwal)->toLocalizedString("d-MMMM-yyyy") . '-' . Time::parse($tglKeluarAkhir)->toLocalizedString("d-MMMM-yyyy") . ".pdf", [
            'Attachment' => 0,
            'compress' => 0
        ]);
        die();
    }
}
