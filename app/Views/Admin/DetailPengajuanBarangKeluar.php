<?php

use CodeIgniter\I18n\Time; ?>
<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-white">
        <div class="col">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Informasi Barang</h3>
                </div>
                <div class="card-body">
                    <p>
                        Tanggal: <b><?= Time::parse($barKel['tanggal_keluar'])->toLocalizedString('d MMMM yyyy'); ?></b> - Pukul: <b><?= Time::parse($barKel['tanggal_keluar'])->toLocalizedString('HH:mm'); ?></b><br />
                        Ditambahkan Oleh: <b><?= $barKel['nama_user']; ?></b><br />
                        Yang diajukan oleh Unit Kerja: <b><?= $barKel['nama_unit_kerja'] ?></b><br />
                        Status: <b><?= $barKel['status'] == 0 ? 'PROSES' : 'SELESAI'; ?></b>
                    </p>
                </div>
            </div>
            <a target="_blank" class="btn btn-primary" href="<?= base_url() . route_to('admin.transaksi.barangkeluar.detail.pdf', $idBarKel); ?>" role="button"><i class="bi bi-file-pdf"></i>&nbsp;Tampilkan PDF</a>
            <div class="table-responsive pt-3">
                <table id="barangkeluarlist" class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kuantitas</th>
                            <th>Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($dbklist as $b) : ?>
                            <tr>
                                <td scope="row"><?= $no++; ?></td>
                                <td><?= $b['nama_barang']; ?></td>
                                <td><?= $b['kuantitas']; ?></td>
                                <td><?= $b['nama_satuan']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>