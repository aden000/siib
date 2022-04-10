<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BarangModel;
use App\Models\DetailBarangModel;
use CodeIgniter\API\ResponseTrait;

class AjaxController extends BaseController
{

    use ResponseTrait;

    public function pusatAjax()
    {
        if ($this->request->isAJAX()) {
            $key = $this->request->getPost('key');
            // return $this->respond($this->request->getVar());
            if (session()->get('SessionAjax') === $key) {
                if ($this->request->getPost('getCountBarang') == true) return $this->getCountBarang();
                if ($this->request->getPost('getQtyBarang') == true) return $this->getQtyBarang();
                if ($this->request->getPost('getTurunanBarang') == true) return $this->getTurunanBarang();
            } else {
                return $this->failForbidden('Key was not valid');
            }
        }
    }
    public function getCountBarang()
    {
        $idBarang = esc($this->request->getPost('idBarang'));
        $bModel = new BarangModel();
        $count = count($bModel->cariDetailBarangBerdasarkanIDBarang($idBarang));

        return $this->respond([
            'success' => true,
            'countBarang' => $count,
            'data' => $bModel->cariDetailBarangBerdasarkanIDBarang($idBarang),
        ], 200);
    }

    public function getQtyBarang()
    {
        $idBarang = esc($this->request->getPost('idBarang'));
        $idSatuan = esc($this->request->getPost('idSatuan'));

        $bModel = new BarangModel();
        return $this->respond([
            'success' => true,
            'data' => $bModel->cariKuantitasBarangBerdasarkanIDBarangDanIDSatuan($idBarang, $idSatuan)
        ], 200);
    }

    public function getTurunanBarang()
    {
        $idBarang = esc($this->request->getPost('idBarang'));
        $idSatuan = esc($this->request->getPost('idSatuan'));

        $dbModel = new DetailBarangModel();
        return $this->respond([
            'success' => true,
            'dataPilihan' => $dbModel->ambilDetailBarangBerdasarkanIDBarangDanIDSatuan($idBarang, $idSatuan),
            'dataAtasan' => $dbModel->ambilDetailBarangAtasanBerdasarkanIDBarangDanIDSatuan($idBarang, $idSatuan),
        ], 200);
    }
}
