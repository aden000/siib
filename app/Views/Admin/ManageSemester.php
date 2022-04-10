<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row">
        <div class="col">
            <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-white">
                <button data-toggle="modal" data-target="#modalTambahSemester" class="btn btn-success mb-3"><i class="bi bi-plus"></i> Tambah Semester</button>
                <!-- Find the datatables customization in JSLTE.php under Template/Admin -->
                <div class="table-responsive">
                    <table id="semesterlist" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Semester ke</th>
                                <th>Tahun</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            // d($katbarlist);
                            foreach ($semesterlist as $semester) : ?>
                                <tr>
                                    <td scope="row"><?= $no++; ?></td>
                                    <td><?= $semester['semester_ke']; ?></td>
                                    <td><?= $semester['tahun']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm" id="ubahSmt" data-toggle="modal" data-target="#modalUpdateSemester" data-id="<?= $semester['id_semester']; ?>" data-semester="<?= $semester['semester_ke']; ?>" data-tahun="<?= $semester['tahun']; ?>">
                                            <i class="bi bi-info-circle"></i>
                                            &nbsp;Ubah
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm" id="delSmt" data-toggle="modal" data-target="#modalDeleteSemester" data-id="<?= $semester['id_semester']; ?>" data-semester="<?= $semester['semester_ke']; ?>" data-tahun="<?= $semester['tahun']; ?>">
                                            <i class="bi bi-trash"></i>
                                            &nbsp;Hapus Semester
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

    <!-- Modal Tambah Semester -->
    <div class="modal fade" id="modalTambahSemester" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Semester</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.semester.create'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="semesterValue">Semester ke-</label>
                            <select class="form-control" name="semesterValue" id="semesterValue">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="yearValue">Tahun</label>
                            <input type="text" class="form-control" maxlength="4" name="yearValue" id="yearValue" aria-describedby="yearValueHelpId" placeholder="...">
                            <small id="yearValueHelpId" class="form-text text-muted">Tahun (maksimal 4 digit [cth: 2020])</small>
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

    <!-- Modal Update Semester -->
    <div class="modal fade" id="modalUpdateSemester" tabindex="-1" role="dialog" aria-labelledby="ubahSemesterTitleID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Semester</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.semester.update'); ?>" method="POST">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="idsmt" id="idsmt">
                    <div class="modal-body">
                        <h6 class="section-heading">Berikut adalah semester dan tahun yang akan diubah</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Semester-ke</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row" id="valtabsmtke"></td>
                                    <td id="valtabthn"></td>
                                </tr>
                            </tbody>
                        </table>
                        <h6 class="section-heading">Masukan data yang anda inginkan</h6>
                        <div class="form-group">
                            <label for="smtval">Semester ke-</label>
                            <select class="form-control" name="smtval" id="smtval">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="thnval">Tahun</label>
                            <input type="text" maxlength="4" class="form-control" name="thnval" id="thnval" aria-describedby="thnHlpID" placeholder="...">
                            <small id="thnHlpID" class="form-text text-muted">Tahun (maksimal 4 digit [cth: 2020])</small>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-arrow-repeat"></i>&nbsp;Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete Semester -->
    <div class="modal fade" id="modalDeleteSemester" tabindex="-1" role="dialog" aria-labelledby="modalDeleteSemesterHelpID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.semester.delete'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="idsmt" id="idsmt">
                    <div class="modal-body">
                        <h6 class="section-heading">Anda akan menghapus data berikut, apakah anda yakin?</h6>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Semester ke-</th>
                                    <th>Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row" id="valdeltabsmtke"></td>
                                    <td id="valdeltabthn"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i>&nbsp;Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $('[id^="ubahSmt"]').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var smtke = $(this).data('semester');
            var thn = $(this).data('tahun');

            $('div.modal#modalUpdateSemester').find('#idsmt').val(id);
            $('div.modal#modalUpdateSemester').find('div.modal-body').find('#valtabsmtke').text(smtke);
            $('div.modal#modalUpdateSemester').find('div.modal-body').find('#valtabthn').text(thn);
        });
        $('[id^="delSmt"]').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var smtke = $(this).data('semester');
            var thn = $(this).data('tahun');

            $('div.modal#modalDeleteSemester').find('#idsmt').val(id);
            $('div.modal#modalDeleteSemester').find('div.modal-body').find('#valdeltabsmtke').text(smtke);
            $('div.modal#modalDeleteSemester').find('div.modal-body').find('#valdeltabthn').text(thn);
        });
    </script>
</div>
<?= $this->endSection(); ?>