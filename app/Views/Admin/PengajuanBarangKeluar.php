<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-gradient-white">
        <div class="col table-responsive">
            <a class="btn btn-success mb-3" href="<?= base_url() . route_to('admin.transaksi.barangkeluar.form'); ?>">&plus;&nbsp;Pengajuan Barang Keluar</a>
            <table id="barangkeluarlist" class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Yang Mengajukan</th>
                        <th>Dilakukan Oleh</th>
                        <th>Tanggal Keluar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($bklist as $b) : ?>
                        <tr>
                            <td scope="row"><?= $no++; ?></td>
                            <td><?= $b['nama_unit_kerja']; ?></td>
                            <td><?= $b['nama_user']; ?></td>
                            <td><?= $b['tanggal_keluar']; ?></td>
                            <td><?= ($b['status'] == 0) ? 'PROSES' : 'SELESAI'; ?></td>
                            <td>
                                <a href="<?= base_url() . route_to('admin.transaksi.barangkeluar.detail', $b['id_barang_keluar']); ?>" class="btn btn-success btn-sm" data-id="<?= $b['id_barang_keluar']; ?>">
                                    <i class="bi bi-info-circle"></i>&nbsp;Detail
                                </a>
                                <a target="_blank" href="<?= base_url() . route_to('admin.transaksi.barangkeluar.detail.pdf', $b['id_barang_keluar']); ?>" class="btn btn-info btn-sm" data-id="<?= $b['id_barang_keluar']; ?>">
                                    <i class="bi bi-file-pdf"></i>&nbsp;PDF
                                </a>
                                <a href="<?= base_url() . route_to('admin.transaksi.barangkeluar.detail.pdf', $b['id_barang_keluar']); ?>" class="btn btn-warning btn-sm" data-id="<?= $b['id_barang_keluar']; ?>">
                                    <i class="bi bi-check-square"></i>&nbsp;Ubah Status
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>