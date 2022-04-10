<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row">
        <div class="col">
            <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-white">
                <button data-toggle="modal" data-target="#modalTambahKategoriBarang" class="btn btn-success mb-3"><i class="bi bi-plus"></i> Tambah Kategori Barang</button>
                <!-- Find the datatables customization in JSLTE.php under Template/Admin -->
                <div class="table-responsive">
                    <table id="katbarlist" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            // d($katbarlist);
                            foreach ($katbarlist as $katbar) : ?>
                                <tr>
                                    <td scope="row"><?= $no++; ?></td>
                                    <td><?= $katbar['nama_kategori_barang']; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm" id="ubahKatBar" data-toggle="modal" data-target="#modalUpdateKategoriBarang" data-id="<?= $katbar['id_kategori_barang']; ?>" data-namkatbar="<?= $katbar['nama_kategori_barang']; ?>">
                                            <i class="bi bi-info-circle"></i>&nbsp;Ubah Nama
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm" id="delKatBar" data-toggle="modal" data-target="#modalDeleteKategoriBarang" data-id="<?= $katbar['id_kategori_barang']; ?>" data-namkatbar="<?= $katbar['nama_kategori_barang']; ?>">
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

    <!-- Modal Tambah Kategori Barang -->
    <div class="modal fade" id="modalTambahKategoriBarang" tabindex="-1" role="dialog" aria-labelledby="mtkbId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.kategoribarang.create'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namakatbar">Nama Kategori Barang</label>
                            <input type="text" class="form-control" name="namakatbar" id="namakatbar" aria-describedby="namakatbarhelpid" placeholder="...">
                            <small id="namakatbarhelpid" class="form-text text-muted">Masukan Nama Kategori Barang</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">&times;&nbsp;Close</button>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>&nbsp;Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ubah/Update Kategori Barang -->
    <div class="modal fade" id="modalUpdateKategoriBarang" tabindex="-1" role="dialog" aria-labelledby="mukbId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Kategori Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.kategoribarang.update'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idKatBar" id="idKatBar">
                        <h6 class="section-heading">Nama Sebelumnya: <b id="oldNamKatBar"></b></h6>
                        <div class="form-group">
                            <label for="newNamKatBar">Nama kategori barang yang baru</label>
                            <input type="text" class="form-control" name="newNamKatBar" id="newNamKatBar" aria-describedby="newNamKatBarHID" placeholder="...">
                            <small id="newNamKatBarHID" class="form-text text-muted">Masukan nama kategori barang yang baru</small>
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

    <!-- Modal Delete Kategori Barang -->
    <div class="modal fade" id="modalDeleteKategoriBarang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.kelola.kategoribarang.delete'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idKatBar" id="idKatBar">
                        <h6>Apakah anda yakin untuk menghapus kategori berikut</h6>
                        <p class="section-heading">Nama Kategori Barang: <b id="willDelKatBar"></b></p>
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
        $('[id^="ubahKatBar"]').click(function(e) {
            e.preventDefault();
            var idkatbar = $(this).data('id');
            var namkatbar = $(this).data('namkatbar');

            $('div.modal#modalUpdateKategoriBarang').find('#idKatBar').val(idkatbar);
            $('div.modal#modalUpdateKategoriBarang').find('h6.section-heading').find('#oldNamKatBar').text(namkatbar);
        });

        $('[id^="delKatBar"]').click(function(e) {
            e.preventDefault();
            var idkatbar = $(this).data('id');
            var namkatbar = $(this).data('namkatbar');

            $('div.modal#modalDeleteKategoriBarang').find('#idKatBar').val(idkatbar);
            $('div.modal#modalDeleteKategoriBarang').find('p.section-heading').find('#willDelKatBar').text(namkatbar);
        });
    </script>
</div>
<?= $this->endSection(); ?>