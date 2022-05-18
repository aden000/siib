<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-lg-2">
        <div class="col-md-4 mb-3">
            <a href="<?= base_url() . route_to('admin.transaksi.barang'); ?>" style="text-decoration: none;">
                <div class="card border-left-info shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center text-info">
                            <div class="col mr-2">
                                <h4 class="mb-0"><?= $countBarang; ?></h4>
                                <small class="text-sm ">Banyaknya Barang Terdaftar</small>
                                <h6 class="mt-2"><b>Klik untuk lihat selengkapnya >></b></h6>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-box-seam text-dark" style="font-size: 2em;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="<?= base_url() . route_to('admin.transaksi.barangmasuk'); ?>" style="text-decoration: none;">
                <div class="card border-left-secondary shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center text-success">
                            <div class="col mr-2">
                                <h4 class="mb-0"><?= $countBarangMasuk; ?></h4>
                                <small class="text-sm font-font-weight-bold">Banyaknya Barang Masuk Tercatat</small>
                                <h6 class="mt-2"><b>Klik untuk lihat selengkapnya >></b></h6>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-box-arrow-in-down text-dark" style="font-size: 2em;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="<?= base_url() . route_to('admin.transaksi.barangkeluar'); ?>" style="text-decoration: none;">
                <div class="card border-danger shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center text-danger">
                            <div class="col mr-2">
                                <h5 class="mb-0 "><?= $countBarangKeluar; ?></h5>
                                <small class="text-sm font-font-weight-bold">Banyaknya Barang Keluar Tercatat</small>
                                <h6 class="mt-2"><b>Klik untuk lihat selengkapnya >></b></h6>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-box-arrow-up text-dark" style="font-size: 2em;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="<?= base_url() . route_to('admin.logaktifitas'); ?>" style="text-decoration: none;">
                <div class="card border-danger shadow h-100">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center text-info">
                            <div class="col mr-2">
                                <h5 class="mb-0 ">Aktifitas Terakhir</h5>
                                <small class="text-sm font-font-weight-bold"><?= $AktifitasTerakhir; ?></small>
                                <br>
                                <h6 class="mt-2"><b>Klik untuk lihat selengkapnya >></b></h6>
                            </div>
                            <div class="col-auto">
                                <i class="bi bi-info-circle" style="font-size: 2em;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>