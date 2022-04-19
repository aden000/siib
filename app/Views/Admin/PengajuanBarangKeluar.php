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
                                <a target="_blank" href="<?= base_url() . route_to('admin.transaksi.barangkeluar.detail', $b['id_barang_keluar']); ?>" class="btn btn-success btn-sm" data-id="<?= $b['id_barang_keluar']; ?>">
                                    <i class="bi bi-info-circle"></i>&nbsp;Detail
                                </a>
                                <a target="_blank" href="<?= base_url() . route_to('admin.transaksi.barangkeluar.detail.pdf', $b['id_barang_keluar']); ?>" class="btn btn-info btn-sm" data-id="<?= $b['id_barang_keluar']; ?>">
                                    <i class="bi bi-file-pdf"></i>&nbsp;PDF
                                </a>
                                <?php if ($b['status'] == 0) : ?>
                                    <a href="#" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalChangeStatus" data-id="<?= $b['id_barang_keluar']; ?>" data-yangmengajukan="<?= $b['nama_unit_kerja']; ?>" data-oleh="<?= $b['nama_user']; ?>" data-tglkeluar="<?= $b['tanggal_keluar']; ?>" data-status="<?= ($b['status'] == 0) ? 'PROSES' : 'SELESAI'; ?>">
                                        <i class="bi bi-check-square"></i>&nbsp;Ubah Status
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Change Status -->
    <div class="modal fade" id="modalChangeStatus" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Ubah Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.transaksi.barangkeluar.ubahstatus'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="idBarKel" id="idBarKel">
                    <div class="modal-body">
                        <div class="card card-outline card-success">
                            <div class="card-header">
                                <h6>Informasi Barang Keluar</h6>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">Yang Mengajukan: <b id="yangMengajukan"></b></h4>
                                <p class="card-text">
                                    Dilakukan Oleh: <b id="dilakukanOleh"></b><br>
                                    Tanggal Keluar: <b id="tanggalKeluar"></b><br>
                                    Status: <b id="status"></b><br>
                                </p>
                            </div>
                            <div class="card-footer text-muted text-right">
                                <a target="_blank" name="detailBarKelLink" id="detailBarKelLink" class="btn btn-success" href="#" role="button">
                                    <i class="bi bi-info-circle"></i>
                                    Detail Barang Keluar
                                </a>
                            </div>
                        </div>
                        <p>
                            Hal ini akan mengubah status dari barang keluar yang anda pilih menjadi selesai,
                            yang dimana proses barang keluar sudah diterima oleh unit kerja yang bersangkutan,
                            apakah anda ingin mengubah status barang keluar ini?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-square"></i>&nbsp;Ubah Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            $('#modalChangeStatus').on('show.bs.modal', function(e) {
                var _btn = e.relatedTarget;
                //retrieval data
                var _idBarangKeluar = $(_btn).data('id');
                var _yangMengajukan = $(_btn).data('yangmengajukan');
                var _dilakukanOleh = $(_btn).data('oleh');
                var _tglKeluar = $(_btn).data('tglkeluar');
                var _status = $(_btn).data('status');

                //set id to hidden input on modal
                $(this).find('#idBarKel').val(_idBarangKeluar);

                //set to view
                $(this).find('#yangMengajukan').text(_yangMengajukan);
                $(this).find('#dilakukanOleh').text(_dilakukanOleh);
                $(this).find('#tanggalKeluar').text(_tglKeluar);
                $(this).find('#status').text(_status);
                $(this).find('#detailBarKelLink').attr('href', '/admin/transaksi/barang-keluar/detail/' + _idBarangKeluar);
            });
        });
    </script>
</div>
<?= $this->endSection(); ?>