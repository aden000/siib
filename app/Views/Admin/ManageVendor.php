<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row">
        <div class="col">
            <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-white">
                <button data-toggle="modal" data-target="#modalTambahVendor" class="btn btn-success mb-3"><i class="bi bi-plus"></i> Tambah Vendor</button>
                <!-- Find the datatables customization in JSLTE.php under Template/Admin -->
                <div class="table-responsive p-1">
                    <table id="vendorlist" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Vendor / Perusahaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            // d($katbarlist);
                            foreach ($vendorlist as $vendor) : ?>
                                <tr>
                                    <td scope="row"><?= $no++; ?></td>
                                    <td><?= $vendor['nama_vendor']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm" id="ubahNamaVendor" data-toggle="modal" data-target="#modalUpdateVendor" data-id="<?= $vendor['id_vendor']; ?>" data-namavendor="<?= $vendor['nama_vendor']; ?>">
                                            <i class="bi bi-info-circle"></i>&nbsp;Ubah Nama
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm" id="hapusNamaVendor" data-toggle="modal" data-target="#modalDeleteVendor" data-id="<?= $vendor['id_vendor']; ?>" data-namavendor="<?= $vendor['nama_vendor']; ?>">
                                            <i class="bi bi-trash"></i>&nbsp;Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Vendor -->
    <div class="modal fade" id="modalTambahVendor" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Vendor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.vendor.create'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaVendor">Nama Vendor</label>
                            <input type="text" class="form-control" name="namaVendor" id="namaVendor" aria-describedby="namaVendorHelpID" placeholder="...">
                            <small id="namaVendorHelpID" class="form-text text-muted">Masukan Nama Vendor</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>&nbsp;Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Update Vendor -->
    <div class="modal fade" id="modalUpdateVendor" tabindex="-1" role="dialog" aria-labelledby="modalUpdateVendorId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Vendor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.vendor.update'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idVendor" id="idVendor">
                        <h6 class="section-heading">Nama Sebelumnya: <b id="oldNamaVendor"></b></h6>
                        <div class="form-group">
                            <label for="newNamaVendor">Nama Vendor baru</label>
                            <input type="text" class="form-control" name="newNamaVendor" id="newNamaVendor" aria-describedby="newNamaVendorId" placeholder="...">
                            <small id="newNamaVendorId" class="form-text text-muted">Masukan nama vendor yang baru</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>&nbsp;Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Vendor -->
    <div class="modal fade" id="modalDeleteVendor" tabindex="-1" role="dialog" aria-labelledby="modalDeleteVendorHelpID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi hapus vendor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.vendor.delete'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idVendor" id="idVendor">
                        <h6>Apakah anda yakin untuk menghapus vendor berikut</h6>
                        <p class="section-heading">Nama Vendor: <b id="willDelVendor"></b></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // var btnUbahVendor = document.querySelectorAll('#ubahNamaVendor');
        // btnUbahVendor.forEach(function(itembtn) {
        //     itembtn.addEventListener('click', function(e) {
        //         e.preventDefault();

        //         document.querySelector('div.modal#modalUpdateVendor')
        //     });
        // });

        $('[id^="ubahNamaVendor"]').click(function(e) {
            e.preventDefault();

            var idVendor = $(this).data('id');
            var namaVendor = $(this).data('namavendor');

            $('div.modal#modalUpdateVendor').find('#idVendor').val(idVendor);
            $('div.modal#modalUpdateVendor').find('h6.section-heading').find('#oldNamaVendor').text(namaVendor);
        });

        $('[id^="hapusNamaVendor"]').click(function(e) {
            e.preventDefault();
            var idvendor = $(this).data('id');
            var namavendor = $(this).data('namavendor');

            $('div.modal#modalDeleteVendor').find('#idVendor').val(idvendor);
            $('div.modal#modalDeleteVendor').find('p.section-heading').find('#willDelVendor').text(namavendor);
        });
    </script>
</div>
<?= $this->endSection(); ?>