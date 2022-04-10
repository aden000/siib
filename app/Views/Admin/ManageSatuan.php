<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row">
        <div class="col">
            <div class="mx-lg-4 p-2 shadow border border-info rounded bg-white">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalTambahSatuan">&plus;&nbsp;Tambah Satuan</button>
                <div class="table-responsive p-1">
                    <table id="satuanlist" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Satuan</th>
                                <th>Singkatan Satuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            // d($katbarlist);
                            foreach ($satuanlist as $satuan) : ?>
                                <tr>
                                    <td scope="row"><?= $no++; ?></td>
                                    <td><?= $satuan['nama_satuan']; ?></td>
                                    <td><?= $satuan['singkatan']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm" id="ubahSatuan" data-toggle="modal" data-target="#modalUbahSatuan" data-id="<?= $satuan['id_satuan']; ?>" data-namasatuan="<?= $satuan['nama_satuan']; ?>" data-singkatan="<?= $satuan['singkatan']; ?>">
                                            <i class="bi bi-info-circle"></i>&nbsp;Ubah Nama
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm" id="hapusSatuan" data-toggle="modal" data-target="#modalHapusSatuan" data-id="<?= $satuan['id_satuan']; ?>" data-namasatuan="<?= $satuan['nama_satuan']; ?>" data-singkatan="<?= $satuan['singkatan']; ?>">
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

    <!-- Modal Tambah Satuan -->
    <div class="modal fade" id="modalTambahSatuan" tabindex="-1" role="dialog" aria-labelledby="TambahNamaSatuahHelpID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.satuan.create'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namasatuan">Nama Satuan</label>
                            <input type="text" class="form-control" name="namasatuan" id="namasatuan" aria-describedby="namasatuanhelpid" placeholder="...">
                            <small id="namasatuanhelpid" class="form-text text-muted">Masukan nama satuan</small>
                        </div>
                        <div class="form-group">
                            <label for="singkatan">Singkatan Satuan</label>
                            <input type="text" class="form-control" name="singkatan" id="singkatan" maxlength="5" aria-describedby="singkatansatuanHelpID" placeholder="...">
                            <small id="singkatansatuanHelpID" class="form-text text-muted">Masukan singkatan (maksimal 5 huruf, cth: Kilogram = Kg, Gram = g)</small>
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

    <!-- Modal Update Satuan -->
    <div class="modal fade" id="modalUbahSatuan" tabindex="-1" role="dialog" aria-labelledby="UbahNamaSatuahHelpID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.satuan.update'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="idsatuan" id="idsatuan">
                    <div class="modal-body">
                        <div class="section-heading">
                            <h6>Berikut data yang akan diubah</h6>
                            <table class="table table-striped bg-white">
                                <thead>
                                    <tr>
                                        <th>Nama Satuan</th>
                                        <th>Singkatan Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row" id="oldNamaSatuan"></td>
                                        <td id="oldSingkatan"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="newnamasatuan">Nama Satuan</label>
                            <input type="text" class="form-control" name="newnamasatuan" id="newnamasatuan" aria-describedby="namasatuanhelpid" placeholder="...">
                            <small id="namasatuanhelpid" class="form-text text-muted">Masukan nama satuan</small>
                        </div>
                        <div class="form-group">
                            <label for="newsingkatan">Singkatan Satuan</label>
                            <input type="text" class="form-control" name="newsingkatan" id="newsingkatan" maxlength="5" aria-describedby="singkatansatuanHelpID" placeholder="...">
                            <small id="singkatansatuanHelpID" class="form-text text-muted">Masukan singkatan (maksimal 5 huruf, cth: Kilogram = Kg, Gram = g)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-repeat"></i>&nbsp;Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Satuan -->
    <div class="modal fade" id="modalHapusSatuan" tabindex="-1" role="dialog" aria-labelledby="HapusNamaSatuahHelpID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Satuan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.satuan.delete'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="idsatuan" id="idsatuan">
                    <div class="modal-body">
                        <div class="section-heading">
                            <h6>Berikut data yang akan dihapus</h6>
                            <table class="table table-striped bg-white">
                                <thead>
                                    <tr>
                                        <th>Nama Satuan</th>
                                        <th>Singkatan Satuan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row" id="oldNamaSatuan"></td>
                                        <td id="oldSingkatan"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <h6>Apakah anda yakin untuk menghapus data ini?</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>&nbsp;Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('[id^="ubahSatuan"]').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var namaSatuan = $(this).data('namasatuan');
            var singkatan = $(this).data('singkatan');

            $('div.modal#modalUbahSatuan').find('#idsatuan').val(id);
            $('div.modal#modalUbahSatuan').find('div.modal-body').find('#oldNamaSatuan').text(namaSatuan);
            $('div.modal#modalUbahSatuan').find('div.modal-body').find('#oldSingkatan').text(singkatan);
        });

        $('[id^="hapusSatuan"]').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var namaSatuan = $(this).data('namasatuan');
            var singkatan = $(this).data('singkatan');

            $('div.modal#modalHapusSatuan').find('#idsatuan').val(id);
            $('div.modal#modalHapusSatuan').find('div.modal-body').find('#oldNamaSatuan').text(namaSatuan);
            $('div.modal#modalHapusSatuan').find('div.modal-body').find('#oldSingkatan').text(singkatan);
        });
    </script>
</div>
<?= $this->endSection(); ?>