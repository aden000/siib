<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <form action="<?= base_url() . route_to('admin.transaksi.barang.create'); ?>" method="post">
        <?= csrf_field(); ?>
        <div class="row mx-4 p-2 shadow border border-info rounded bg-white">
            <div class="col">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>Petunjuk Pengisian</strong> <br>
                    <p>
                        Kategori Barang merupakan data yang diambil dari Manajemen Referensi > <a target="_blank" href="<?= base_url() . route_to('admin.kelola.kategoribarang'); ?>"><b>Kelola Kategori Barang <i class="bi bi-box-arrow-up-right"></i></b></a> <br>
                        Nama Barang merupakan Nama dari sebuah barang atau merek <br>
                        Satuan merupakan Unit dari barang, yang dapat berupa Pieces (bijian), Pack, atau Box
                    <ul>
                        <li><b>1</b> Slof mempunyai <b>10</b> Pack</li>
                        <li><b>1</b> Pack mempunyai <b>12</b> Pcs</li>
                    </ul>
                    Jadi untuk mengisi barang sebagai berikut
                    <ol>
                        <li>Masukan Kategori Barang, jika belum didaftarkan silahkan menuju Manajemen Referensi > <a target="_blank" href="<?= base_url() . route_to('admin.kelola.kategoribarang'); ?>"><b>Kelola Kategori Barang <i class="bi bi-box-arrow-up-right"></i></b></a> pada Sidebar</li>
                        <li>Masukan Nama Barang</li>
                        <li>Bagian Bawah adalah satuan yang bisa digunakan dalam barang ini, contoh: barang A dapat berupa Box, Pack, Pcs dsb, Tombol Plus <a class="btn btn-success" href="#" role="button" style="text-decoration: none;">&plus;</a> pada bagian kanan akan menambah isian satuan yang digunakan dalam barang nanti</li>
                        <li>Contoh: Satuan: 1 Box berisi 5 pack, berarti anda dapat memilih satuan Box dan turunan satuannya adalah Pack, dan kuantitas konversinya adalah 5</li>
                        <li>Jika belum paham silahkan hubungi administrator untuk mempelajari lebih lanjut</li>
                    </ol>
                    </p>
                </div>

                <script>
                    $(".alert").alert();
                </script>
                <div class="form-group">
                    <label for="kategoribarang">Kategori Barang</label>
                    <select class="form-control select2-modaltb" name="kategoribarang">
                        <option selected disabled hidden>Pilih satu ..</option>
                        <?php foreach ($katbarlist as $katbar) : ?>
                            <option value="<?= $katbar['id_kategori_barang']; ?>"><?= $katbar['nama_kategori_barang']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="namabarang">Nama Barang</label>
                    <input type="text" class="form-control" name="namabarang" id="namabarang" aria-describedby="namabaranghelpid" placeholder="...">
                    <small id="namabaranghelpid" class="form-text text-muted">Masukan nama barang</small>
                </div>
                <div class="yangBakalAppend border border-dark p-2 rounded">
                    <div class="yangBakalClone">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="satuan">Pilih Satuan</label>
                                    <select class="form-control select2-modaltb" name="satuan[]">
                                        <option selected disabled hidden>Pilih Satu..</option>
                                        <?php foreach ($satuanlist as $satuan) : ?>
                                            <option value="<?= $satuan['id_satuan']; ?>" data-namasatuan="<?= $satuan['nama_satuan']; ?>"><?= $satuan['nama_satuan'] . ' - ' . $satuan['singkatan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="turunansatuan">Pilih Turunan Satuan</label>
                                    <select class="form-control select2-modaltb turunansatuan" name="turunansatuan[]">
                                        <option value="0">Satuan ini adalah satuan terkecil</option>
                                        <?php foreach ($satuanlist as $satuan) : ?>
                                            <option value="<?= $satuan['id_satuan']; ?>" data-namasatuan="<?= $satuan['nama_satuan']; ?>"><?= $satuan['nama_satuan'] . ' - ' . $satuan['singkatan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="konvtursatuan">Kuantitas Konversi Turunan Satuan</label>
                                    <input type="number" class="form-control konvtursatuan" name="konvtursatuan[]" aria-describedby="konvtursatuanHelpID" placeholder="..." readonly value="0">
                                    <small id="konvtursatuanHelpID" class="form-text text-muted">Konversi kuantitas terhadap turunan satuan</small>
                                </div>
                            </div>
                            <div class="col-auto">
                                <table class="table table-hover table-borderless">
                                    <tr>
                                        <td><button class="btn btn-success btnAddIsianSatuanBarang" title="Tambah Isian Satuan Barang"><i class="bi bi-plus"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><button class="btn btn-danger btnDelIsianSatuanBarang" title="Hapus Isian Satuan Barang"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-4 p-2 shadow border border-info rounded bg-white">
            <div class="col"></div>
            <div class="col-auto">

                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>&nbsp;Save</button>
            </div>
        </div>
    </form>
</div>
<script>
    var counterIsianBarang = 0
    $(function() {
        $('.select2-modaltb').select2({
            theme: "bootstrap",
            width: "auto",
            dropdownAutoWidth: true,
        });
    });
    $('select.select2-modaltb.turunansatuan').change(function(e) {
        e.preventDefault();
        let val = $(e.target).val();
        val = parseInt(val);
        console.log(val);
        if (val === 0) {
            console.log('added');
            $(this).parents('div.yangBakalClone').find('input.konvtursatuan').attr('readonly', 'readonly');
        } else {
            console.log('removed');
            $(this).parents('div.yangBakalClone').find('input.konvtursatuan').removeAttr('readonly');
        }
    });
    $('input.konvtursatuan').keypress(function(e) {
        var key = String.fromCharCode(e.which)
        console.log(key);
        if (key.match('/[\e\-\+\.]/gi')) {
            e.stopPropagation();
            return;
        }
    });
    $('button.btnAddIsianSatuanBarang').click(function(e) {
        e.preventDefault();
        $(this).parents('div.yangBakalClone').find('select.select2-modaltb').select2('destroy');
        var clone = $(this).parents('div.yangBakalClone').clone(true);
        clone.find('input.konvtursatuan').removeAttr('readonly');
        clone.find('input.konvtursatuan').val(0);
        clone.find('input.konvtursatuan').attr('readonly', 'readonly');
        $('div.yangBakalAppend').append(clone);
        $('select.select2-modaltb').select2({
            theme: "bootstrap",
            width: "auto",
            dropdownAutoWidth: true,
        });
        counterIsianBarang++;
    });
    $('button.btnDelIsianSatuanBarang').click(function(e) {
        e.preventDefault();
        if (counterIsianBarang === 0) {
            Swal.fire({
                titleText: 'Tidak dapat menghapus isian paling pertama',
                text: 'Anda tidak dapat menghapus isian paling awal',
                icon: 'error'
            })
            return
        }
        $(this).parents('div.yangBakalClone').find('select.select2-modaltb').select2('destroy');
        $(this).parents('div.yangBakalClone').remove();
        $('select.select2-modaltb').select2({
            theme: "bootstrap",
            width: "auto",
            dropdownAutoWidth: true,
        });
        counterIsianBarang--;
    });
</script>
<?= $this->endSection(); ?>