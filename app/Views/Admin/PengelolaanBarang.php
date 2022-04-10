<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-gradient-white">
        <div class="col table-responsive">
            <a class="btn btn-success mb-3" href="<?= base_url() . route_to('admin.transaksi.barang.tambah'); ?>">&plus;&nbsp;Tambah Barang</a>
            <table id="baranglist" class="table table-sm table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Kategori Barang</th>
                        <th>Kuantitas & Satuan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($baranglist as $b) : ?>
                        <tr>
                            <td scope="row"><?= $no++; ?></td>
                            <td><?= $b['nama_barang']; ?></td>
                            <td><?= $b['nama_kategori_barang']; ?></td>
                            <td>
                                <p>
                                    <a name="btnDetailBarang" id="btnDetailBarang" class="btn btn-sm btn-info" href="<?= base_url() . route_to('admin.transaksi.barang.detail', $b['id_barang']); ?>" role="button"><i class="bi bi-info-circle"></i>&nbsp;Detail Barang</a>
                                </p>
                            </td>
                            <td>
                                <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalUbahBarang" data-id="<?= $b['id_barang']; ?>" data-namabarang="<?= $b['nama_barang']; ?>" data-katbar="<?= $b['nama_kategori_barang']; ?>">
                                    <i class="bi bi-info-circle"></i>&nbsp;Ubah Nama
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modalDeleteBarang" data-id="<?= $b['id_barang']; ?>" data-namabarang="<?= $b['nama_barang']; ?>" data-katbar="<?= $b['nama_kategori_barang']; ?>">
                                    <i class="bi bi-trash"></i>&nbsp;Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Update Barang -->
    <div class="modal fade" id="modalUbahBarang" tabindex="-1" role="dialog" aria-labelledby="modalUbahBarangHelpId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.transaksi.barang.update'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idBarang" id="idBarang">
                        <div class="section-heading">
                            <h6>Berikut barang yang akan diubah</h6>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Kategori Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row" id="yangDiIsiNamaBarang"></td>
                                        <td id="yangDiIsiKategoriBarang"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="katbar">Kategori Barang</label>
                            <select class="form-control select2-modalub" name="katbar" id="katbar">
                                <option>Pilih Satu..</option>
                                <?php foreach ($katbarlist as $k) : ?>
                                    <option value="<?= $k['id_kategori_barang']; ?>"><?= $k['nama_kategori_barang']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="namaBarang">Nama Barang</label>
                            <input type="text" class="form-control" name="namaBarang" id="namaBarang" aria-describedby="namaBarangHelpID" placeholder="...">
                            <small id="namaBarangHelpID" class="form-text text-muted">Nama Barang yang akan diupdate</small>
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

    <!-- Modal -->
    <div class="modal fade" id="modalDeleteBarang" tabindex="-1" role="dialog" aria-labelledby="modalDeleteBarangHelpID" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.transaksi.barang.delete'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idBarang" id="idBarang">
                        <div class="section-heading">
                            <h6>Berikut barang yang akan dihapus</h6>
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Kategori Barang</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td scope="row" id="yangDiIsiNamaBarang"></td>
                                        <td id="yangDiIsiKategoriBarang"></td>
                                    </tr>
                                </tbody>
                            </table>
                            <h6>Apakah anda ingin menghapus barang ini?<br /> <a target="_blank" id="yangDiIsiLink">Detail barang <i class="bi bi-box-arrow-up-right"></i></a> yang terkait akan dihapus</h6>
                        </div>
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
        $('div.modal#modalUbahBarang').on('show.bs.modal', function(e) {
            var btn = e.relatedTarget;
            var id = $(btn).data('id');
            var namabarang = $(btn).data('namabarang');
            var namkatbar = $(btn).data('katbar');
            $(this).find('div.modal-body').find('#idBarang').val(id);
            $(this).find('div.modal-body').find('#yangDiIsiNamaBarang').text(namabarang);
            $(this).find('div.modal-body').find('#yangDiIsiKategoriBarang').text(namkatbar);
        });
        $('div.modal#modalDeleteBarang').on('show.bs.modal', function(e) {
            var btn = e.relatedTarget;
            var id = $(btn).data('id');
            var namabarang = $(btn).data('namabarang');
            var namkatbar = $(btn).data('katbar');
            $(this).find('div.modal-body').find('#idBarang').val(id);
            $(this).find('div.modal-body').find('#yangDiIsiNamaBarang').text(namabarang);
            $(this).find('div.modal-body').find('#yangDiIsiKategoriBarang').text(namkatbar);
            $(this).find('div.modal-body').find('#yangDiIsiLink').attr('href', '/admin/transaksi/barang/detail/' + id);
        });

        $('select.select2-modalub').select2({
            theme: "bootstrap",
            width: "auto",
            dropdownAutoWidth: true,
            dropdownParent: $('div.modal#modalUbahBarang')
        });
    </script>
</div>
<?= $this->endSection(); ?>