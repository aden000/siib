<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-lg-4 p-2 shadow border border-info rounded bg-white">
        <div class="col">
            <a href="<?= base_url() . route_to('admin.transaksi.barangmasuk.tambah'); ?>" class="btn btn-success">&plus;&nbsp;Tambah Barang</a>
            <div class="table-responsive pt-3">
                <table id="barangmasuklist" class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Yang Menambahkan</th>
                            <th>Vendor yang dipilih</th>
                            <th>Pengadaan Semester</th>
                            <th>Tanggal Masuk Pengadaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($bmlist as $b) : ?>
                            <tr>
                                <td scope="row"><?= $no++; ?></td>
                                <td><?= $b['nama_user']; ?></td>
                                <td><?= $b['nama_vendor']; ?></td>
                                <td><?= 'Semester ' . $b['semester_ke'] . ' - ' . $b['tahun']; ?></td>
                                <td><?= $b['tanggal_masuk'] ?></td>
                                <td>
                                    <a href="<?= base_url() . route_to('admin.transaksi.barangmasuk.detail', $b['id_barang_masuk']); ?>" class="btn btn-success btn-sm" data-id="<?= $b['id_barang_masuk']; ?>">
                                        <i class="bi bi-info-circle"></i>&nbsp;Detail
                                    </a>
                                    <a target="_blank" href="<?= base_url() . route_to('admin.transaksi.barangmasuk.detail.pdf', $b['id_barang_masuk']); ?>" class="btn btn-info btn-sm" data-id="<?= $b['id_barang_masuk']; ?>">
                                        <i class="bi bi-file-pdf"></i>&nbsp;PDF
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('.select2-modaltbm').select2({
                theme: "bootstrap",
                width: "auto",
                dropdownAutoWidth: true,
                dropdownParent: $('#modalTambahBarangMasuk'),
            });
            $('select.select2-modaltbm#brngTambah').change(function(e) {
                e.preventDefault();
                var id = $(this).val()
                console.log(id);

            });
        });
        $('#btnSubmitHasAdded').click(function(e) {
            e.preventDefault();
            $('#hasAddedForm').submit();
        });
    </script>
</div>
<?= $this->endSection(); ?>