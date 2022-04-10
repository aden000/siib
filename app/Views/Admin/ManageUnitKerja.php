<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row">
        <div class="col">
            <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-white">
                <button data-toggle="modal" data-target="#modalTambahUnitKerja" class="btn btn-success mb-3"><i class="bi bi-plus"></i> Tambah Unit Kerja</button>
                <!-- Find the datatables customization in JSLTE.php under Template/Admin -->
                <div class="table-responsive p-1">
                    <table id="unitkerjalist" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Unit Kerja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            // d($katbarlist);
                            foreach ($unitkerjalist as $unitkerja) : ?>
                                <tr>
                                    <td scope="row"><?= $no++; ?></td>
                                    <td><?= $unitkerja['nama_unit_kerja']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm" id="ubahNamaUnitKerja" data-toggle="modal" data-target="#modalUpdateUnitKerja" data-id="<?= $unitkerja['id_unit_kerja']; ?>" data-namunker="<?= $unitkerja['nama_unit_kerja']; ?>">
                                            <i class="bi bi-info-circle"></i>&nbsp;Ubah Nama
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm" id="hapusNamaUnitKerja" data-toggle="modal" data-target="#modalDeleteUnitKerja" data-id="<?= $unitkerja['id_unit_kerja']; ?>" data-namunker="<?= $unitkerja['nama_unit_kerja']; ?>">
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

    <!-- Modal Tambah Unit Kerja -->
    <div class="modal fade" id="modalTambahUnitKerja" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Unit Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.unitkerja.create'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namaUnitKerja">Nama Unit Kerja</label>
                            <input type="text" class="form-control" name="namaUnitKerja" id="namaUnitKerja" aria-describedby="namaUnitKerjaHelpID" placeholder="...">
                            <small id="namaUnitKerjaHelpID" class="form-text text-muted">Masukan Nama Unit Kerja</small>
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

    <!-- Modal Update Unit Kerja -->
    <div class="modal fade" id="modalUpdateUnitKerja" tabindex="-1" role="dialog" aria-labelledby="modalUpdateUnitKerjaId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Unit Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.unitkerja.update'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idUnitKerja" id="idUnitKerja">
                        <h6 class="section-heading">Nama Sebelumnya: <b id="oldNamaUnitKerja"></b></h6>
                        <div class="form-group">
                            <label for="newNamaUnitKerja">Nama Unit Kerja baru</label>
                            <input type="text" class="form-control" name="newNamaUnitKerja" id="newNamaUnitKerja" aria-describedby="newNamaUnitKerjaId" placeholder="...">
                            <small id="newNamaUnitKerjaId" class="form-text text-muted">Masukan nama unit kerja yang baru</small>
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

    <!-- Modal Delete Unit Kerja -->
    <div class="modal fade" id="modalDeleteUnitKerja" tabindex="-1" role="dialog" aria-labelledby="modalDeleteUnitKerjaHelpID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi hapus unit kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.unitkerja.delete'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idUnitKerja" id="idUnitKerja">
                        <h6>Apakah anda yakin untuk menghapus unit kerja berikut</h6>
                        <p class="section-heading">Nama Unit Kerja: <b id="willDelUnitKerja"></b></p>
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
        // var btnUbahUnitKerja = document.querySelectorAll('#ubahNamaUnitKerja');
        // btnUbahUnitKerja.forEach(function(itembtn) {
        //     itembtn.addEventListener('click', function(e) {
        //         e.preventDefault();

        //         document.querySelector('div.modal#modalUpdateUnitKerja')
        //     });
        // });

        $('[id^="ubahNamaUnitKerja"]').click(function(e) {
            e.preventDefault();

            var idUnitKerja = $(this).data('id');
            var namaUnitKerja = $(this).data('namunker');

            $('div.modal#modalUpdateUnitKerja').find('#idUnitKerja').val(idUnitKerja);
            $('div.modal#modalUpdateUnitKerja').find('h6.section-heading').find('#oldNamaUnitKerja').text(namaUnitKerja);
        });

        $('[id^="hapusNamaUnitKerja"]').click(function(e) {
            e.preventDefault();
            var idunitkerja = $(this).data('id');
            var namaunitkerja = $(this).data('namunker');

            $('div.modal#modalDeleteUnitKerja').find('#idUnitKerja').val(idunitkerja);
            $('div.modal#modalDeleteUnitKerja').find('p.section-heading').find('#willDelUnitKerja').text(namaunitkerja);
        });
    </script>
</div>
<?= $this->endSection(); ?>