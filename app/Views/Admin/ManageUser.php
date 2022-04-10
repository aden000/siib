<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-white">
        <button data-toggle="modal" data-target="#modalCreateUser" class="btn btn-success mb-3"><i class="bi bi-plus"></i> Tambah User</button>
        <!-- Find the datatables customization in JSLTE.php under Template/Admin -->
        <div class="table-responsive">
            <table id="userlist" class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>User Akses</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($userlist as $u) : ?>
                        <tr>
                            <td scope="row"><?= $no++; ?></td>
                            <td><?= $u['nama_user']; ?></td>
                            <td><?= $u['username']; ?></td>
                            <td>
                                <?php if ($u['role'] == 1) : ?>
                                    Pusat Sistem Informasi
                                <?php elseif ($u['role'] == 2) : ?>
                                    Bagian Keuangan
                                <?php elseif ($u['role'] == 3) : ?>
                                    Yayasan
                                <?php else : ?>
                                    Belum Didefinisikan
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#userInfoModal" class="btn btn-success btn-sm" data-id="<?= $u['id_user']; ?>" data-namauser="<?= $u['nama_user']; ?>" data-username="<?= $u['username']; ?>" data-role="<?= $u['role']; ?>">
                                    <i class="bi bi-info-circle"></i>&nbsp;Ubah Info
                                </a>
                                <?php if ($userdata['id_user'] !== $u['id_user']) : ?>
                                    <a href="#" class="btn btn-warning btn-sm resetPass" data-id="<?= $u['id_user']; ?>" data-namauser="<?= $u['nama_user']; ?>">
                                        <i class="bi bi-key"></i>&nbsp;Reset Password
                                    </a>
                                    <a href="#" class="btn btn-danger btn-sm delUser" data-id="<?= $u['id_user']; ?>" data-namauser="<?= $u['nama_user']; ?>">
                                        <i class="bi bi-trash"></i>&nbsp;Hapus User
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <form action="<?= base_url() . route_to('admin.users.resetpass'); ?>" method="post" id="formResetPassUser">
        <?= csrf_field(); ?>
        <input type="hidden" name="resetPassIdUser" id="resetPassIdUser">
    </form>

    <form action="<?= base_url() . route_to('admin.users.delete'); ?>" method="post" id="formDelUser">
        <?= csrf_field(); ?>
        <input type="hidden" name="delIdUser" id="delIdUser">
    </form>

    <!-- Modal Create User -->
    <div class="modal fade" id="modalCreateUser" tabindex="-1" role="dialog" aria-labelledby="modalCreateUserHelpID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.users.create'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama Pengguna</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= old('nama'); ?>" aria-describedby="namaHelpID" placeholder="...">
                            <small id="namaHelpID" class="form-text text-muted">Masukan nama yang akan ditampilkan pada sistem</small>
                        </div>
                        <div class="form-group">
                            <label for="uname">Username</label>
                            <input type="text" class="form-control" name="uname" id="uname" value="<?= old('uname'); ?>" aria-describedby="unameHelpID" placeholder="...">
                            <small id="unameHelpID" class="form-text text-muted">Masukan Username yang akan digunakan sebagai akses ke sistem</small>
                        </div>
                        <div class="form-group">
                            <label for="pword">Password</label>
                            <input type="password" class="form-control" name="pword" id="pword" value="<?= old('pword'); ?>" aria-describedby="pwordHelpID" placeholder="...">
                            <small id="pwordHelpID" class="form-text text-muted">Masukan Password yang digunakan untuk akses sistem</small>
                        </div>
                        <div class="form-group">
                            <label for="kpword">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="kpword" id="kpword" value="<?= old('kpword'); ?>" aria-describedby="pwordHelpID" placeholder="...">
                            <small id="pwordHelpID" class="form-text text-muted">Masukan ulang password yang akan digunakan</small>
                        </div>
                        <div class="form-group">
                            <label for="role">Hak Akses</label>
                            <select class="form-control" name="role" id="role">
                                <option value="1" <?= old('role') == 1 ? 'selected' : ''; ?>>Pusat Sistem Informasi</option>
                                <option value="2" <?= old('role') == 2 ? 'selected' : ''; ?>>Bagian Keuangan</option>
                                <option value="3" <?= old('role') == 3 ? 'selected' : ''; ?>>Yayasan</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>&nbsp;Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Update User-->
    <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Info User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.users.update'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" class="editIdUser" name="editIdUser" id="editIdUser">
                        <div class="form-group">
                            <label for="editNama">Nama User</label>
                            <input type="text" class="form-control editName" name="editNama" id="editNama" aria-describedby="editNamaHelpID" placeholder="..." required>
                            <small id="editNamaHelpID" class="form-text text-muted">Nama yang akan ditampilkan di sistem</small>
                        </div>
                        <div class="form-group">
                            <label for="editUserName">Username</label>
                            <input type="text" class="form-control editUserName" name="editUserName" id="editUserName" aria-describedby="editUserName" placeholder="..." required>
                            <small id="editUserName" class="form-text text-muted">Username yang akan digunakan dalam sistem</small>
                        </div>
                        <div class="form-group">
                            <label for="role">Hak Akses</label>
                            <select class="form-control editRole" name="role" id="role">
                                <option value="1">Pusat Sistem Informasi</option>
                                <option value="2">Bagian Keuangan</option>
                                <option value="3">Yayasan</option>
                            </select>
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
    <script>
        $(function() {
            $('#userInfoModal').on('show.bs.modal', function(e) {
                var btn = e.relatedTarget;
                var id_user = $(btn).data('id');
                var nama = $(btn).data('namauser');
                var username = $(btn).data('username');
                var role = $(btn).data('role');

                $(this).find('.editIdUser').val(id_user);
                $(this).find('.editName').val(nama);
                $(this).find('.editUserName').val(username);
                $(this).find('.editRole').val(role);
            });
            $('.delUser').click(function(e) {
                e.preventDefault();
                var id_user = $(this).data('id');
                var nama_user = $(this).data('namauser');

                Swal.fire({
                    titleText: 'Apakah anda yakin untuk menghapus user: ' + nama_user + '?',
                    html: 'Tindakan ini tidak dapat dibatalkan setelah klik tombol \'YA\'',
                    icon: 'question',
                    showDenyButton: true,
                    confirmButtonText: 'YA',
                    denyButtonText: 'TIDAK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formDelUser').find('#delIdUser').val(id_user);
                        $('#formDelUser').submit();
                    } else if (result.isDenied) {
                        Swal.fire('Penghapusan user dibatalkan', '', 'info')
                    }
                });
            });
            $('.resetPass').click(function(e) {
                e.preventDefault();
                var id_user = $(this).data('id');
                var nama_user = $(this).data('namauser');

                Swal.fire({
                    titleText: 'Apakah anda yakin untuk mereset password user: ' + nama_user + '?',
                    html: 'Tindakan ini tidak dapat dibatalkan setelah klik tombol \'<strong>YA</strong>\'<br>Password akan diambil secara default sesuai konfigurasi file \'.env\'<pre>RESET_PASSWORD_VALUE_DEFAULT</pre>',
                    icon: 'question',
                    showDenyButton: true,
                    confirmButtonText: 'YA',
                    denyButtonText: 'TIDAK',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formResetPassUser').find('#resetPassIdUser').val(id_user);
                        $('#formResetPassUser').submit();
                    } else if (result.isDenied) {
                        Swal.fire('Reset password untuk user \'' + nama_user + '\' dibatalkan', '', 'info')
                    }
                });
            });
        });
    </script>
</div>
<?= $this->endSection(); ?>