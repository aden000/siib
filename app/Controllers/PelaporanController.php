<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;

class PelaporanController extends BaseController
{
    public function manajemenPelaporan()
    {
        $this->breadcrumbs[] = [
            'namelink' => 'Manajemen Pelaporan',
            'link' => base_url() . route_to('admin.pelaporan')
        ];

        $bModel = new BarangModel();

        return view('Admin/ManagePelaporan', [
            'judul' => 'Manajemen Pelaporan',
            'userdata' => $this->userdata,
            'breadcrumbs' => $this->breadcrumbs,
            'blist' => $bModel->findAll(),
        ]);
    }

    // public function pelaporanReferensi()
    // {
    // }

    // public function pelaporanBarang()
    // {
    //     $bList = esc($this->request->getPost('barang'));
    //     $bModel = new BarangModel();

    //     $data = [];
    //     foreach ($bList as $b) {
    //         $data[] = [
    //             'barang' => $bModel->find($b),
    //             'detail_barang' => $bModel->cariDetailBarangBerdasarkanIDBarang($b),
    //         ];
    //     }

    //     // dd($data);
    //     PDFController::makePDFPelaporanBarang($data);
    // }

    // public function pelaporanBarangMasuk()
    // {
    // }
}
