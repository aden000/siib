<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-4 p-2 shadow border border-info rounded bg-white">
        <div class="col">
            <form action="<?= base_url() . route_to('admin.transaksi.barangkeluar.create'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="form-group">
                    <label for="unitKerja">Unit Kerja yang mengajukan</label>
                    <select class="form-control select2-tbk" name="unitKerja" id="unitKerja">
                        <option selected hidden disabled>Pilih Satu..</option>
                        <?php foreach ($uklist as $u) : ?>
                            <option value="<?= $u['id_unit_kerja']; ?>"><?= $u['nama_unit_kerja']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Memuat...</div>
                </div>
                <div class="yangBakalAppend">
                    <div class="yangBakalClone">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="brng[]">Barang</label>
                                    <select class="form-control select2-tbk brngQty" name="brng[]">
                                        <option selected hidden disabled>Pilih Satu..</option>
                                        <?php foreach ($blist as $brng) : ?>
                                            <option value="<?= $brng['id_barang']; ?>"><?= $brng['nama_barang']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-muted" id="brngQtyHlpID">Pilih Satu</small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="satuan">Pilih Satuan</label>
                                    <select class="form-control select2-tbk satuanClass" name="satuan[]">

                                    </select>
                                    <small class="form-text text-muted infoQty">Pilih satuan...</small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="qty[]">Kuantitas yang akan digunakan</label>
                                    <input type="number" class="form-control qtyUsed" name="qty[]" aria-describedby="qtyHelpID" placeholder="..." required>
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
                </div>
                <div class="row">
                    <div class="col"></div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>&nbsp;Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(function() {
            $('.progress').hide();
            var counterBarang = 0;
            $('.select2-tbk').select2({
                theme: "bootstrap",
                width: "auto",
                dropdownAutoWidth: true,
            });
            $('select.select2-tbk.brngQty').change(function(e) {
                e.preventDefault();
                // console.log('changed');

                var optSelect = $('option:selected', this);
                var val = optSelect.val();
                var optBarang = this;
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
                                text: element.nama_satuan,
                            });
                        }
                        console.log(optBarang);
                        $(optBarang).parents('.yangBakalClone').find('select.select2-tbk.satuanClass').find('option').remove().end();
                        if ($(optBarang).parents('.yangBakalClone').find('select.select2-tbk.satuanClass').hasClass("select2-hidden-accessible")) {
                            $(optBarang).parents('.yangBakalClone').find('select.select2-tbk.satuanClass').select2('destroy');
                        }
                        // console.log(dataSatuanMulti);

                        // console.log($(optBarang).parents('.yangBakalClone').find('select.select2-tbk.satuanClass'));

                        $(optBarang).parents('.yangBakalClone').find('select.select2-tbk.satuanClass').select2({
                            theme: "bootstrap",
                            width: "auto",
                            dropdownAutoWidth: true,
                            data: dataSatuanMulti
                        });

                        var firstChange = $(optBarang).parents('.yangBakalClone').find('select.select2-tbk.satuanClass').find('option:selected').val()
                        for (let i = 0; i < response.countBarang; i++) {
                            var element = response.data[i];
                            if (element.id_satuan === firstChange) {
                                $(optBarang).parents('.yangBakalClone').find('small.infoQty').text('Kuantitas saat ini: ' + element.kuantitas);
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
            $('select.satuanClass.select2-tbk').change(function(e) {
                e.preventDefault();
                var optSelect = $('option:selected', this);
                var idBarang = $(this).parents('div.yangBakalClone').find('select.brngQty').find('option:selected').val();
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

                        optSelect.parents('div.yangBakalClone').find('small.infoQty').text('Kuantitas saat ini: ' + qty);
                        $('.progress').find('.progress-bar').css('width', '100%');
                        $('.progress').hide(500);
                    }
                });
            });

            $('button.btnAddIsianBarang').click(function(e) {
                e.preventDefault();
                $(this).parents('div.yangBakalClone').find('select.select2-tbk').select2('destroy');
                var clone = $(this).parents('div.yangBakalClone').clone(true, true);
                clone.find('#brngQtyHlpID').text('Pilih Satu')
                clone.find('select.select2-tbk.satuanClass').find('option').remove().end();
                clone.find('small.infoQty').text('Pilih Satuan...');
                clone.find('input.qtyUsed').val('');
                $(this).parents('form').find('.yangBakalAppend').append(clone);
                $('select.select2-tbk').select2({
                    theme: "bootstrap",
                    width: "auto",
                    dropdownAutoWidth: true,
                });
                counterBarang++;
            });
            $('button.btnDelIsianBarang').click(function(e) {
                e.preventDefault();
                if (counterBarang === 0) {
                    Swal.fire({
                        titleText: 'Tidak dapat menghapus isian paling pertama',
                        text: 'Anda tidak dapat menghapus isian paling awal',
                        icon: 'error'
                    })
                    return
                }
                $(this).parents('div.yangBakalClone').find('select.select2-tbk').select2('destroy');
                $(this).parents('div.yangBakalClone').remove()
                $('select.select2-tbk').select2({
                    theme: "bootstrap",
                    width: "auto",
                    dropdownAutoWidth: true,
                });
                counterBarang--;
            });
        });
    </script>
</div>
<?= $this->endSection(); ?>