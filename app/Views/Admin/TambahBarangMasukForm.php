<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-4 p-2 shadow border border-info rounded bg-white">
        <div class="col">
            <form action="<?= base_url() . route_to('admin.transaksi.barangmasuk.create'); ?>" method="post" id="hasAddedForm">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="smtBrngTambah">Pengadaan Semester</label>
                            <select class="form-control select2-tbm" name="smtBrngTambah" id="smtBrngTambah">
                                <option selected hidden disabled>Pilih Satu..</option>
                                <?php foreach ($smtlist as $smt) : ?>
                                    <option value="<?= $smt['id_semester']; ?>"><?= 'Semester ke-' . $smt['semester_ke'] . ' - Tahun ' . $smt['tahun']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="vendorBrngTambah">Dari Vendor / Perusahaan</label>
                            <select class="form-control select2-tbm" name="vendorBrngTambah" id="vendorBrngTambah">
                                <option selected disabled hidden>Pilih Satu..</option>
                                <?php foreach ($vlist as $v) : ?>
                                    <option value="<?= $v['id_vendor']; ?>"><?= $v['nama_vendor']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Memuat...</div>
                </div>
                <div class="yangDiAppend">
                    <div class="row yangBakalClone">
                        <div class="col">
                            <div class="form-group">
                                <label for="brngTambah">Masukan barang</label>
                                <select class="form-control select2-tbm brngtambah" name="brngTambah[]">
                                    <option selected disabled hidden>Pilih satu..</option>
                                    <?php foreach ($blist as $brng) : ?>
                                        <option value="<?= $brng['id_barang']; ?>"><?= $brng['nama_barang']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group satuanfield">
                                <label for="satuan">Pilih satuan</label>
                                <select class="form-control satuan select2-tbm" name="satuan[]">

                                </select>
                                <small class="form-text text-muted qtyNow">Pilih satuan untuk melihat kuantitas saat ini</small>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="qty">Kuantitas</label>
                                <input type="number" class="form-control qtyAdd" name="qty[]" aria-describedby="qtyHelpID" placeholder="..." required>
                                <small id="qtyHelpID" class="form-text text-muted">Masukan Kuantitas</small>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="row">
                                <table class="table table-hover table-borderless">
                                    <tr>
                                        <td><button class="btn btn-success btnAddIsianBarang" title="Tambah Isian Barang"><i class="bi bi-plus"></i></button></td>
                                    </tr>
                                    <tr>
                                        <td><button class="btn btn-danger btnDelIsianBarang" title="Hapus Isian Barang"><i class="bi bi-trash"></i></button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col"></div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= csrf_field(); ?>
<script>
    var counterIsianBarang = 0
    // var clone_clonean;
    $(function() {
        $('.baseClone').hide();
        $('.progress').hide();
        $('select.select2-tbm').select2({
            theme: "bootstrap",
            width: "auto",
            dropdownAutoWidth: true,
        });
        $('select.select2-tbm.brngtambah').change(function(e) {
            e.preventDefault();
            let val = $(e.target).val();
            var optButton = this;
            $('.progress').find('.progress-bar').css('width', '25%');
            $('.progress').show();
            $.ajax({
                type: "POST",
                url: "<?= base_url() . route_to('admin.pusatajax'); ?>",
                data: {
                    key: '<?= $key; ?>',
                    getCountBarang: true,
                    idBarang: val
                },
                dataType: "json",
                success: function(response) {
                    $('.progress').find('.progress-bar').css('width', '75%');
                    var dataSatuanMulti = [];

                    console.log(response.countBarang);

                    for (let i = 0; i < response.countBarang; i++) {
                        var element = response.data[i];

                        dataSatuanMulti.push({
                            id: element.id_satuan,
                            text: element.nama_satuan
                        });
                    }
                    $(optButton).parents('.row.yangBakalClone').find('select.satuan.select2-tbm').find('option').remove().end();
                    if ($(optButton).parents('.row.yangBakalClone').find('select.satuan.select2-tbm').hasClass("select2-hidden-accessible")) {
                        $(optButton).parents('.row.yangBakalClone').find('select.satuan.select2-tbm').select2('destroy');
                    }

                    console.log(dataSatuanMulti);
                    $(optButton).parents('.yangBakalClone').find('select.satuan.select2-tbm').select2({
                        theme: "bootstrap",
                        width: "auto",
                        dropdownAutoWidth: true,
                        data: dataSatuanMulti
                    });

                    var firstChange = $(optButton).parents('div.row.yangBakalClone').find('select.select2-tbm.satuan').find('option:selected').val()
                    for (let i = 0; i < response.countBarang; i++) {
                        var element = response.data[i];
                        if (element.id_satuan === firstChange) {
                            $(optButton).parents('div.row.yangBakalClone').find('small.qtyNow').text('Kuantitas Saat Ini : ' + element.kuantitas);
                            break;
                        }
                    }

                    $('.progress').find('.progress-bar').css('width', '100%');
                    $('.progress').hide(500);

                },
                error: function(err, status, errthrow) {
                    console.log('error');
                    console.log(err);
                }
            });
        });

        $('select.satuan.select2-tbm').change(function(e) {
            e.preventDefault();
            var optSelect = $('option:selected', this);
            var idBarang = $(this).parents('div.yangBakalClone').find('select.brngtambah').find('option:selected').val();
            var idSatuan = optSelect.val();
            $('.progress').find('.progress-bar').css('width', '25%');
            $('.progress').show();

            console.log(idBarang, idSatuan);
            $.ajax({
                type: "POST",
                url: "<?= base_url() . route_to('admin.pusatajax'); ?>",
                data: {
                    key: '<?= $key ?>',
                    getQtyBarang: true,
                    idBarang: idBarang,
                    idSatuan: idSatuan
                },
                dataType: "json",
                success: function(response) {
                    $('.progress').find('.progress-bar').css('width', '75%');

                    var qty = response.data

                    $(optSelect).parents('div.row.yangBakalClone').find('small.qtyNow').text('Kuantitas Saat Ini : ' + qty);
                    $('.progress').find('.progress-bar').css('width', '100%');
                    $('.progress').hide(500);

                }
            });
        });

        $('.btnAddIsianBarang').click(function(e) {
            e.preventDefault();
            $(this).parents('div.row.yangBakalClone').find('select.select2-tbm').select2('destroy');
            var clone = $(this).parents('div.row.yangBakalClone').clone(true, true);
            // clone.find('#brngQtyHlpID').text('Pilih Satu')
            clone.find('select.select2-tbm.satuan').find('option').remove().end();
            clone.find('input.qtyAdd').val('');
            $(this).parents('.yangDiAppend').append(clone);
            $('select.select2-tbm').select2({
                theme: "bootstrap",
                width: "auto",
                dropdownAutoWidth: true,
                // dropdownParent: $(this).parents('div.yangBakalClone'),
            });
            counterIsianBarang++;
        });
        $('.btnDelIsianBarang').click(function(e) {
            e.preventDefault();
            if (counterIsianBarang === 0) {
                Swal.fire({
                    titleText: 'Tidak dapat menghapus isian paling pertama',
                    text: 'Anda tidak dapat menghapus isian paling awal',
                    icon: 'error'
                })
                return
            }
            $(this).parents('div.row.yangBakalClone').find('select.select2-tbm').select2('destroy');
            $(this).parents('div.row.yangBakalClone').remove()
            $('select.select2-tbm').select2({
                theme: "bootstrap",
                width: "auto",
                dropdownAutoWidth: true,
                // dropdownParent: $('div.yangBakalClone'),
            });
            counterIsianBarang--;
        });
    });
</script>
<?= $this->endSection(); ?>