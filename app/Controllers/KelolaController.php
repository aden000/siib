<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KategoriBarangModel;
use App\Models\SatuanModel;
use App\Models\SemesterModel;
use App\Models\UnitKerjaModel;
use App\Models\VendorModel;

class KelolaController extends BaseController
{
    //Kategori Barang Section
    public function indexKategoriBarang()
    {
        $katbarlist = new KategoriBarangModel();
        $katbarlist = $katbarlist->findAll();
        $this->breadcrumbs[] = [
            'namelink' => 'Kelola Kategori Barang',
            'link' => base_url() . route_to('admin.kelola.kategoribarang')
        ];
        return view('Admin/ManageKategoriBarang', [
            'judul' => 'Kelola Kategori Barang',
            'userdata' => $this->userdata,
            'katbarlist' => $katbarlist,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }
    public function createKategoriBarang()
    {
        $namakatbar = esc($this->request->getPost('namakatbar'));
        if (!is_null($namakatbar)) {
            $model = new KategoriBarangModel();
            $model->insert([
                'nama_kategori_barang' => $namakatbar
            ]);
            $errors = $model->errors();
            if (empty($errors)) {
                return redirect()->route('admin.kelola.kategoribarang')->with('info', [
                    'judul' => 'Penambahan kategori barang berhasil',
                    'msg' => 'Kategori barang ditambahkan dengan sukses',
                    'role' => 'success'
                ]);
            } else {
                $msgerr = '<ul>';
                foreach ($errors as $e) {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
                $msgerr .= '</ul>';
                return redirect()->route('admin.kelola.kategoribarang')->with('info', [
                    'judul' => 'Penambahan kategori barang gagal',
                    'msg' => $msgerr,
                    'role' => 'error'
                ]);
            }
        } else {
            return redirect()->route('admin.kelola.kategoribarang')->with('info', [
                'judul' => 'Penambahan kategori barang gagal',
                'msg' => 'Anda belum mengisi nama kategori barang',
                'role' => 'error'
            ]);
        }
    }
    public function updateKategoriBarang()
    {
        $idKatBar = esc($this->request->getPost('idKatBar'));
        $newNamKatBar = esc($this->request->getPost('newNamKatBar'));

        if (!is_null($newNamKatBar)) {
            $KatBarModel = new KategoriBarangModel();
            $KatBarModel->update($idKatBar, [
                'nama_kategori_barang' => $newNamKatBar
            ]);

            $errors = $KatBarModel->errors();
            if (empty($errors)) {
                return redirect()->route('admin.kelola.kategoribarang')->with('info', [
                    'judul' => 'Pengubahan kategori barang berhasil',
                    'msg' => 'Pengubahan nama kategori barang berjalan dengan sukses',
                    'role' => 'success'
                ]);
            } else {
                $msgerr = '<ul>';
                foreach ($errors as $e) {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
                $msgerr .= '</ul>';
                return redirect()->route('admin.kelola.kategoribarang')->with('info', [
                    'judul' => 'Pengubahan kategori barang gagal',
                    'msg' => $msgerr,
                    'role' => 'error'
                ]);
            }
        } else {
            return redirect()->route('admin.kelola.kategoribarang')->with('info', [
                'judul' => 'Pengubahan kategori barang gagal',
                'msg' => 'Anda belum mengisi nama kategori barang yang baru',
                'role' => 'error'
            ]);
        }
    }

    public function deleteKategoriBarang()
    {
        $idKatBar = esc($this->request->getPost('idKatBar'));

        $KatBarModel = new KategoriBarangModel();
        $KatBarModel->delete($idKatBar);
        $errors = $KatBarModel->errors();

        if (empty($errors)) {
            return redirect()->route('admin.kelola.kategoribarang')->with('info', [
                'judul' => 'Penghapusan kategori barang berhasil',
                'msg' => 'Penghapusan nama kategori barang berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                if (strpos($e, 'constraint')) {
                    $cust_e = "Kategori ini masih digunakan sebagai referensi pada tabel barang, hubungi administrator untuk mendapat info lebih lanjut";
                    $msgerr .= '<li>' . esc($cust_e) . '</li>';
                } else {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.kategoribarang')->with('info', [
                'judul' => 'Penghapusan kategori barang gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    //Unit Kerja Section
    public function indexUnitKerja()
    {
        $unitkerjalist = new UnitKerjaModel();
        $unitkerjalist = $unitkerjalist->findAll();
        $this->breadcrumbs[] = [
            'namelink' => 'Kelola Unit Kerja',
            'link' => base_url() . route_to('admin.kelola.unitkerja')
        ];
        return view('Admin/ManageUnitKerja', [
            'judul' => 'Kelola Unit Kerja',
            'userdata' => $this->userdata,
            'unitkerjalist' => $unitkerjalist,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }
    public function createUnitKerja()
    {
        $namaUnitKerja = esc($this->request->getPost('namaUnitKerja'));

        $model = new UnitKerjaModel();
        $model->insert([
            'nama_unit_kerja' => $namaUnitKerja
        ]);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.unitkerja')->with('info', [
                'judul' => 'Penambahan unit kerja berhasil',
                'msg' => 'Penambahan nama unit kerja berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.unitkerja')->with('info', [
                'judul' => 'Penambahan unit kerja gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }
    public function updateUnitKerja()
    {
        $id = esc($this->request->getPost('idUnitKerja'));
        $namaUnitKerja = esc($this->request->getPost('newNamaUnitKerja'));

        $model = new UnitKerjaModel();
        $model->update($id, [
            'nama_unit_kerja' => $namaUnitKerja
        ]);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.unitkerja')->with('info', [
                'judul' => 'Pengubahan unit kerja berhasil',
                'msg' => 'Pengubahan nama unit kerja berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.unitkerja')->with('info', [
                'judul' => 'Pengubahan unit kerja gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    public function deleteUnitKerja()
    {
        $id = esc($this->request->getPost('idUnitKerja'));
        $unitkerja = new UnitKerjaModel();
        $unitkerja->delete($id);

        $errors = $unitkerja->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.unitkerja')->with('info', [
                'judul' => 'Penghapusan unit kerja berhasil',
                'msg' => 'Penghapusan nama unit kerja berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                if (strpos($e, 'constraint')) {
                    $cust_e = "Unit Kerja ini masih digunakan sebagai referensi pada tabel barang keluar, hubungi administrator untuk mendapat info lebih lanjut";
                    $msgerr .= '<li>' . esc($cust_e) . '</li>';
                } else {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.unitkerja')->with('info', [
                'judul' => 'Penghapusan unit kerja gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }
    //Vendor Section
    public function indexVendor()
    {
        $vendorlist = new VendorModel();
        $vendorlist = $vendorlist->findAll();
        $this->breadcrumbs[] = [
            'namelink' => 'Kelola Vendor',
            'link' => base_url() . route_to('admin.kelola.vendor')
        ];
        return view('Admin/ManageVendor', [
            'judul' => 'Kelola Vendor',
            'userdata' => $this->userdata,
            'vendorlist' => $vendorlist,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }
    public function createVendor()
    {
        $namaVendor = esc($this->request->getPost('namaVendor'));

        $model = new VendorModel();
        $model->insert([
            'nama_vendor' => $namaVendor
        ]);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.vendor')->with('info', [
                'judul' => 'Penambahan vendor berhasil',
                'msg' => 'Penambahan nama vendor berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.vendor')->with('info', [
                'judul' => 'Penambahan vendor gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }
    public function updateVendor()
    {
        $id = esc($this->request->getPost('idVendor'));
        $namaVendor = esc($this->request->getPost('newNamaVendor'));

        $model = new VendorModel();
        $model->update($id, [
            'nama_vendor' => $namaVendor
        ]);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.vendor')->with('info', [
                'judul' => 'Pengubahan vendor berhasil',
                'msg' => 'Pengubahan nama vendor berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.vendor')->with('info', [
                'judul' => 'Pengubahan vendor gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    public function deleteVendor()
    {
        $id = esc($this->request->getPost('idVendor'));
        $vendor = new VendorModel();
        $vendor->delete($id);

        $errors = $vendor->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.vendor')->with('info', [
                'judul' => 'Penghapusan vendor berhasil',
                'msg' => 'Penghapusan nama vendor berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                if (strpos($e, 'constraint')) {
                    $cust_e = "Vendor ini masih digunakan sebagai referensi pada tabel barang masuk, hubungi administrator untuk mendapat info lebih lanjut";
                    $msgerr .= '<li>' . esc($cust_e) . '</li>';
                } else {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.vendor')->with('info', [
                'judul' => 'Penghapusan vendor gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    //Semester Section
    public function indexSemester()
    {
        $semesterlist = new SemesterModel();
        $semesterlist = $semesterlist->orderBy('tahun DESC, semester_ke ASC')->findAll();
        $this->breadcrumbs[] = [
            'namelink' => 'Kelola Semester',
            'link' => base_url() . route_to('admin.kelola.semester')
        ];
        return view('Admin/ManageSemester', [
            'judul' => 'Kelola Semester',
            'userdata' => $this->userdata,
            'semesterlist' => $semesterlist,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function createSemester()
    {
        $semester = esc($this->request->getPost('semesterValue'));
        $tahun = esc($this->request->getPost('yearValue'));

        $model = new SemesterModel();
        $model->insert([
            'semester_ke' => $semester,
            'tahun' => $tahun
        ]);

        $errors = $model->errors();

        if (empty($errors)) {
            return redirect()->route('admin.kelola.semester')->with('info', [
                'judul' => 'Pembuatan semester berhasil',
                'msg' => 'Pembuatan nama semester berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.semester')->with('info', [
                'judul' => 'Pembuatan semester gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    public function updateSemester()
    {
        $id = esc($this->request->getPost('idsmt'));
        $smtval = esc($this->request->getPost('smtval'));
        $thnval = esc($this->request->getPost('thnval'));

        $model = new SemesterModel();
        $model->update($id, [
            'semester_ke' => $smtval,
            'tahun' => $thnval
        ]);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.semester')->with('info', [
                'judul' => 'Pengubahan semester berhasil',
                'msg' => 'Pengubahan semester berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.semester')->with('info', [
                'judul' => 'Pengubahan semester gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    public function deleteSemester()
    {
        $id = esc($this->request->getPost('idsmt'));

        $model = new SemesterModel();
        $model->delete($id);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.semester')->with('info', [
                'judul' => 'Penghapusan semester berhasil',
                'msg' => 'Penghapusan semester berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                if (strpos($e, 'constraint')) {
                    $cust_e = "Semester ini masih digunakan sebagai referensi pada tabel barang masuk, hubungi administrator untuk mendapat info lebih lanjut";
                    $msgerr .= '<li>' . esc($cust_e) . '</li>';
                } else {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.semester')->with('info', [
                'judul' => 'Penghapusan semester gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }

    //Satuan Section
    public function indexSatuan()
    {
        $satuanlist = new SatuanModel();
        $satuanlist = $satuanlist->findAll();
        $this->breadcrumbs[] = [
            'namelink' => 'Kelola Satuan',
            'link' => base_url() . route_to('admin.kelola.satuan')
        ];
        return view('Admin/ManageSatuan', [
            'judul' => 'Kelola Satuan',
            'userdata' => $this->userdata,
            'satuanlist' => $satuanlist,
            'breadcrumbs' => $this->breadcrumbs,
        ]);
    }

    public function createSatuan()
    {
        $namaSatuan = esc($this->request->getPost('namasatuan'));
        $singkatan = esc($this->request->getPost('singkatan'));

        $model = new SatuanModel();
        $model->insert([
            'nama_satuan' => $namaSatuan,
            'singkatan' => $singkatan
        ]);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.satuan')->with('info', [
                'judul' => 'Penambahan Satuan berhasil',
                'msg' => 'Penambahan satuan dilakukan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.satuan')->with('info', [
                'judul' => 'Penambahan satuan gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }
    public function updateSatuan()
    {
        $id = esc($this->request->getPost('idsatuan'));
        $newNamaSatuan = esc($this->request->getPost('newnamasatuan'));
        $newSingkatan = esc($this->request->getPost('newsingkatan'));
        if (empty($id)) {
            return redirect()->route('admin.kelola.satuan')->with('info', [
                'judul' => 'Error tidak diduga',
                'msg' => 'id satuan tidak dapat di-identifikasi, hubungi administrator',
                'role' => 'error'
            ]);
        }

        $model = new SatuanModel();
        $model->update($id, [
            'nama_satuan' => $newNamaSatuan,
            'singkatan' => $newSingkatan
        ]);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.satuan')->with('info', [
                'judul' => 'Pengubahan Satuan Berhasil!',
                'msg' => 'Pengubahan Satuan dilakukan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                $msgerr .= '<li>' . esc($e) . '</li>';
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.satuan')->with('info', [
                'judul' => 'Pengubahan satuan gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }
    public function deleteSatuan()
    {
        $id = esc($this->request->getPost('idsatuan'));
        if (empty($id)) {
            return redirect()->route('admin.kelola.satuan')->with('info', [
                'judul' => 'Error tidak diduga',
                'msg' => 'id satuan tidak dapat di-identifikasi, hubungi administrator',
                'role' => 'error'
            ]);
        }

        $model = new SatuanModel();
        $model->delete($id);

        $errors = $model->errors();
        if (empty($errors)) {
            return redirect()->route('admin.kelola.satuan')->with('info', [
                'judul' => 'Penghapusan satuan berhasil',
                'msg' => 'Penghapusan satuan berjalan dengan sukses',
                'role' => 'success'
            ]);
        } else {
            $msgerr = '<ul>';
            foreach ($errors as $e) {
                if (strpos($e, 'constraint')) {
                    $cust_e = "Satuan ini masih digunakan sebagai referensi pada tabel barang masuk, hubungi administrator untuk mendapat info lebih lanjut";
                    $msgerr .= '<li>' . esc($cust_e) . '</li>';
                } else {
                    $msgerr .= '<li>' . esc($e) . '</li>';
                }
            }
            $msgerr .= '</ul>';
            return redirect()->route('admin.kelola.satuan')->with('info', [
                'judul' => 'Penghapusan satuan gagal',
                'msg' => $msgerr,
                'role' => 'error'
            ]);
        }
    }
}
