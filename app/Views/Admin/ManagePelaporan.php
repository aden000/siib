<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row">
        <div class="col">
            <div class="mx-lg-4 p-3 shadow border border-info rounded bg-white">
                <h6 class="section-heading">Klik salah satu pilihan dibawah ini untuk memperbesar menu</h6>
                <div class="card card-outline card-danger collapsed-card">
                    <a href="#" data-card-widget="collapse" style="text-decoration: none; color: inherit;">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Daftar Referensi</h3>
                            <div class="card-tools">
                                <div class="btn btn-tool"><i class="bi bi-plus"></i></div>
                            </div>
                        </div>
                    </a>
                    <div class="card-body">
                        <form action="<?= base_url() . route_to('admin.pelaporan.referensi'); ?>" method="post" target="_blank">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="referensi">Pilih Referensi yang diinginkan</label>
                                <select class="form-control select2-mp referensi" name="referensi[]" multiple required>
                                    <option value="1">Kategori Barang</option>
                                    <option value="2">Unit Kerja</option>
                                    <option value="3">Vendor / Perusahaan</option>
                                    <option value="4">Semester</option>
                                    <option value="5">Satuan</option>
                                </select>
                                <br />
                                <button type="button" class="btn btn-success checkAll"><i class="bi bi-check"></i>&nbsp;Isi Semua</button>
                                <button type="button" class="btn btn-danger resetAll"><i class="bi bi-x"></i>&nbsp;Hapus Semua</button>
                                <button type="submit" class="btn btn-info"><i class="bi bi-file-pdf"></i>&nbsp;Buat PDF</button>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="overlay dark">
                        <i class="bi bi-arrow-repeat anim_spin" style="font-size: xx-large; color: white;"></i>
                    </div> -->
                </div>
                <div class="card card-outline card-success collapsed-card">
                    <a href="#" data-card-widget="collapse" style="text-decoration: none; color: inherit;">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Daftar Barang</h3>
                            <div class="card-tools">
                                <div class="btn btn-tool"><i class="bi bi-plus"></i></div>
                            </div>
                        </div>
                    </a>
                    <div class="card-body">
                        <form action="<?= base_url() . route_to('admin.pelaporan.barang'); ?>" method="post" target="_blank">
                            <div class="form-group">
                                <?= csrf_field(); ?>
                                <label for="barang">Pilih barang yang diinginkan</label>
                                <select class="form-control select2-mp barang" name="barang[]" multiple required>
                                    <?php foreach ($blist as $b) : ?>
                                        <option value="<?= $b['id_barang']; ?>"><?= $b['nama_barang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <br />
                                <button type="button" class="btn btn-success checkAll"><i class="bi bi-check"></i>&nbsp;Isi Semua</button>
                                <button type="button" class="btn btn-danger resetAll"><i class="bi bi-x"></i>&nbsp;Hapus Semua</button>
                                <button type="submit" class="btn btn-info"><i class="bi bi-file-pdf"></i>&nbsp;Buat PDF</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card card-outline card-warning collapsed-card">
                    <a href="#" data-card-widget="collapse" style="text-decoration: none; color: inherit;">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Barang Masuk</h3>
                            <div class="card-tools">
                                <div class="btn btn-tool"><i class="bi bi-plus"></i></div>
                            </div>
                        </div>
                    </a>
                    <div class="card-body">
                        <form action="<?= base_url() . route_to('admin.pelaporan.barangmasuk'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="barang">Pilih barang yang diinginkan</label>
                                        <select class="form-control select2-mp" name="barang">
                                            <?php foreach ($blist as $b) : ?>
                                                <option value="<?= $b['id_barang']; ?>"><?= $b['nama_barang']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="fromBarangMasuk">Dari Tanggal</label>
                                        <input type="date" class="form-control date" name="fromBarangMasuk" id="fromBarangMasuk" aria-describedby="fromBarangMasukHelpID" placeholder="..." required>
                                        <small id="fromBarangMasukHelpID" class="form-text text-muted">Format Tanggal (mm/dd/yyyy)</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="toBarangMasuk">Ke Tanggal</label>
                                        <input type="date" class="form-control date" name="toBarangMasuk" id="toBarangMasuk" aria-describedby="toBarangMasukHelpID" placeholder="..." required>
                                        <small id="toBarangMasukHelpID" class="form-text text-muted">Format Tanggal (mm/dd/yyyy)</small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info"><i class="bi bi-file-pdf"></i>&nbsp;Buat PDF</button>
                        </form>
                    </div>
                </div>
                <div class="card card-outline card-secondary collapsed-card">
                    <a href="#" data-card-widget="collapse" style="text-decoration: none; color: inherit;">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bold">Barang Keluar</h3>
                            <div class="card-tools">
                                <div class="btn btn-tool"><i class="bi bi-plus"></i></div>
                            </div>
                        </div>
                    </a>
                    <div class="card-body">
                        <form action="<?= base_url() . route_to('admin.pelaporan.barangkeluar'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="barang">Pilih barang yang diinginkan</label>
                                        <select class="form-control select2-mp" name="barang">
                                            <?php foreach ($blist as $b) : ?>
                                                <option value="<?= $b['id_barang']; ?>"><?= $b['nama_barang']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="fromBarangKeluar">Dari Tanggal</label>
                                        <input type="date" class="form-control date" name="fromBarangKeluar" id="fromBarangKeluar" aria-describedby="fromBarangKeluarHelpID" placeholder="...">
                                        <small id="fromBarangKeluarHelpID" class="form-text text-muted">Format Tanggal (mm/dd/yyyy)</small>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="toBarangKeluar">Ke Tanggal</label>
                                        <input type="date" class="form-control date" name="toBarangKeluar" id="toBarangKeluar" aria-describedby="toBarangKeluarHelpID" placeholder="...">
                                        <small id="toBarangKeluarHelpID" class="form-text text-muted">Format Tanggal (mm/dd/yyyy)</small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info"><i class="bi bi-file-pdf"></i>&nbsp;Buat PDF</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('.select2-mp').select2({
                theme: "bootstrap",
                width: "auto",
                dropdownAutoWidth: true,
            });
            $('.checkAll').click(function(e) {
                e.preventDefault();
                $(this).parents('.form-group').find('select.select2-mp > option').each(function() {
                    $(this).prop('selected', true);
                }).trigger('change');

            });
            $('.resetAll').click(function(e) {
                e.preventDefault();
                $(this).parents('.form-group').find('select.select2-mp').val('').trigger('change');
            });
            $('.date').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                yearRange: '1980:2200'
            });
            // $('.fromBarangMasuk').attr('type', 'text').daterangepicker({
            //     singleDatePicker: true,
            //     showDropdowns: true,
            //     minYear: 1945,
            //     maxYear: parseInt(moment().format('YYYY'), 10)
            // });
            // $('.toBarangMasuk').attr('type', 'text').daterangepicker({
            //     singleDatePicker: true,
            //     showDropdown: true,
            //     minYear: 1945,
            //     maxYear: parseInt(moment().format('YYYY'), 10)
            // });
        });
    </script>
</div>
<?= $this->endSection(); ?>