<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row mx-4 p-2 shadow border border-info rounded bg-white">
        <div class="col">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalCreateDetailBarang" data-idbarang="<?= $barang['id_barang']; ?>">
                &plus;&nbsp;Tambah Detail Barang
            </button>
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modalKonversiKuantitas" data-idbarang="<?= $barang['id_barang']; ?>">
                <i class="bi bi-arrow-repeat"></i>&nbsp;Konversi Kuantitas Barang
            </button>
            <div class="table-responsive mt-3">
                <table class="table table-stripped table-sm" id="detailbaranglist">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Satuan</th>
                            <th>Kuantitas</th>
                            <th>Turunan</th>
                            <th>Kuantitas Konversi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($detailbaranglist as $db) : ?>
                            <tr>
                                <td scope="row"><?= $no++; ?></td>
                                <td><?= $db['nama_satuan']; ?></td>
                                <td><?= $db['kuantitas']; ?></td>
                                <td><?= is_null($db['nama_turunan_satuan']) ? 'Tidak ada (Satuan Terkecil)' : $db['nama_turunan_satuan']; ?></td>
                                <td><?= $db['konversi_turunan']; ?></td>
                                <td>
                                    <a href="#" class="btn btn-danger btn-sm" id="delDetailBarang" data-toggle="modal" data-target="#modalDeleteDetailBarang" data-id="<?= $db['id_detail_barang']; ?>" data-idbarang="<?= $db['id_barang']; ?>" data-barang="<?= $db['nama_barang']; ?>" data-satuan="<?= $db['nama_satuan']; ?>" data-turunansatuan="<?= $db['nama_turunan_satuan']; ?>" data-konversi="<?= $db['konversi_turunan']; ?>">
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

    <!-- Modal Tambah Detail Barang-->
    <div class="modal fade" id="modalCreateDetailBarang" tabindex="-1" role="dialog" aria-labelledby="modalCreateDetailBarangHelpID" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Detail Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.transaksi.barang.detail.create'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idBarang" id="idBarang">
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <select class="form-control select2-modaltdb" name="satuan">
                                <option selected disabled hidden>Pilih Satu..</option>
                                <?php foreach ($satuanlist as $s) : ?>
                                    <option value="<?= $s['id_satuan']; ?>"><?= $s['nama_satuan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="turunanSatuan">Turunan Satuan</label>
                            <select class="form-control select2-modaltdb" name="turunanSatuan" id="turunanSatuan">
                                <option value="0">Satuan ini adalah satuan terkecil</option>
                                <?php foreach ($satuanlist as $s) : ?>
                                    <option value="<?= $s['id_satuan']; ?>"><?= $s['nama_satuan']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="konversiTurunan">Kuantitas Konversi Turunan Satuan</label>
                            <input type="number" class="form-control" name="konversiTurunan" id="konversiTurunan" aria-describedby="konvturhelpid" placeholder="..." value="0" readonly>
                            <small id="konvturhelpid" class="form-text text-muted">Contoh: Satuan: 1 Box berisi 5 pack, berarti anda dapat memilih satuan Box dan turunan satuannya adalah Pack, dan kuantitas konversinya adalah 5</small>
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

    <!-- Modal Delete Detail Barang -->
    <div class="modal fade" id="modalDeleteDetailBarang" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus detail barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.transaksi.barang.detail.delete'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="idDetailBarang" id="idDetailBarang">
                    <input type="hidden" name="idBarangDel" id="idBarangDel">
                    <div class="modal-body">
                        <div class="section-heading">
                            <h4 id="barang"></h4>
                            <h6>
                                Apakah anda ingin menghapus salah satu detail barang berikut dari barang diatas?
                            </h6>
                        </div>
                        <table class="table table-stripped table-sm">
                            <thead>
                                <tr>
                                    <th>Satuan</th>
                                    <th>Turunan</th>
                                    <th>Konversi terhadap Turunan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="row" id="yangDiIsiSatuan"></td>
                                    <td id="yangDiIsiTurunan"></td>
                                    <td id="yangDiIsiKonversi"></td>
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
    <!-- Modal Konversi Kuantitas -->
    <div class="modal fade" id="modalKonversiKuantitas" tabindex="-1" role="dialog" aria-labelledby="modalKonversiKuantitasHelpID" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konversi Kuantitas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url() . route_to('admin.transaksi.barang.konversi'); ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="idBarangKonversi" id="idBarangKonversi">
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">Memuat...</div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="satuanBase">Pilih Satuan yang akan ditambahkan kuantitasnya</label>
                                    <select class="form-control select2-modalkonvbar satuanBase" name="satuanBase">
                                        <option selected disabled hidden>Pilih Satu..</option>
                                        <?php foreach ($detailbaranglist as $s) : ?>
                                            <option value="<?= $s['id_satuan']; ?>"><?= $s['nama_satuan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-muted qtyNow">Pilih satu</small>
                                    <input type="hidden" name="qtyNowHidden" id="qtyNowHidden" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="satuanAtasan">Satuan Atasan</label>
                                    <select class="form-control satuanAtasanForm" name="satuanAtasan" disabled>
                                        <option selected>Pilih Satu dari Satuan...</option>
                                        <option value="-1">Tidak ada satuan atasan (Satuan tertinggi)</option>
                                        <option value="0">Tidak Ada (Satuan dasar)</option>
                                        <?php foreach ($satuanlist as $s) : ?>
                                            <option value="<?= $s['id_satuan']; ?>"><?= $s['nama_satuan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="hidden" name="qtyNowAtasanHidden" id="qtyNowAtasanHidden" disabled>
                                    <small class="form-text text-muted qtyAtasanNow">Pilih satu</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="qtyConvert">Konversi Kuantitas terhadap satuan yang dipilih</label>
                                    <input type="number" class="form-control qtyConvert" name="qtyConvert" aria-describedby="qtyConvertHelpID" placeholder="..." disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="qtyExchange">Banyaknya barang pada Satuan Atasan yang akan dikonversi</label>
                                    <input type="number" class="form-control qtyExchange" name="qtyExchange" aria-describedby="qtyExchangeHelpID" placeholder="...">
                                    <small id="qtyExchangeHelpID" class="form-text text-muted">Pilih Satu dari Satuan diatas</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="qtyConvertPlusExisting">Kuantitas yang dihasilkan + Kuantitas satuan pilihan</label>
                                    <input type="text" class="form-control qtyConvertPlusExisting" name="qtyConvertPlusExisting" aria-describedby="qtyConvertPlusExistingHelpID" placeholder="0" disabled>
                                    <small id="qtyConvertPlusExistingHelpID" class="form-text text-muted qtyConvertPlusExistingSmallText">Pilih Satu dari Satuan diatas</small>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btnSubmitKonversiBarang">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('.progress').hide();
            $('.btnSubmitKonversiBarang').hide();
            $('.qtyExchange').attr('disabled', 'disabled');
            $('[id^="delDetailBarang"]').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var idbarang = $(this).data('idbarang');
                var barang = $(this).data('barang');
                var satuan = $(this).data('satuan');
                var turunan_satuan = $(this).data('turunansatuan');
                var konversi = $(this).data('konversi');

                $('#barang').text(barang);
                $('#idDetailBarang').val(id);
                $('#idBarangDel').val(idbarang);
                $('#yangDiIsiSatuan').text(satuan);
                $('#yangDiIsiTurunan').text((turunan_satuan === '') ? 'Tidak Ada (Satuan terkecil)' : turunan_satuan);
                $('#yangDiIsiKonversi').text(konversi);

            });
            $('div.modal#modalCreateDetailBarang').on('show.bs.modal', function(e) {
                var btn = e.relatedTarget;
                var id_barang = $(btn).data('idbarang');

                $(this).find('div.modal-body').find('#idBarang').val(id_barang);
            })
            $('div.modal#modalKonversiKuantitas').on('show.bs.modal', function(e) {
                var btn = e.relatedTarget;
                var id_barang = $(btn).data('idbarang');
                console.log(id_barang);

                $(this).find('div.modal-body').find('#idBarangKonversi').val(id_barang);
            });

            $('.satuanBase').change(function(e) {
                e.preventDefault();
                let optBarang = $('option:selected', this)
                let val = optBarang.val();
                var id_barang = $(this).parents('.modal-body').find('#idBarangKonversi').val()
                $('.qtyExchange').val('').change();
                $(this).parents('.modal-body').find('.qtyConvertPlusExisting').val('');

                console.log(id_barang, val);

                $('.progress').find('.progress-bar').css('width', '25%');
                $('.progress').show();

                $.ajax({
                    type: "post",
                    url: "<?= base_url() . route_to('admin.pusatajax') ?>",
                    data: {
                        key: "<?= $key ?>",
                        getTurunanBarang: true,
                        idBarang: id_barang,
                        idSatuan: val
                    },
                    dataType: "json",
                    success: function(response) {
                        //getdata success
                        $('.progress').find('.progress-bar').css('width', '75%');
                        console.log(response);
                        if (response.success) {
                            $(optBarang).parents('.modal-body').find('.qtyNow').text('Kuantitas saat ini: ' + response.dataPilihan.kuantitas);
                            $(optBarang).parents('.modal-body').find('input#qtyNowHidden').val(response.dataPilihan.kuantitas);
                            $(optBarang).parents('.modal-body').find('.qtyConvertPlusExistingSmallText').text('Pilih Satu dari Satuan diatas');
                            if (response.dataAtasan === null) {
                                $(optBarang).parents('.modal-body').find('.satuanAtasanForm').val(-1).change();
                                $(optBarang).parents('.modal-body').find('.qtyConvert').val('');
                                $(optBarang).parents('.modal-body').find('input#qtyNowAtasanHidden').val('');
                                $(optBarang).parents('.modal-body').find('.qtyAtasanNow').text('Pilih Satu...');
                                $(optBarang).parents('.modal-body').find('.qtyExchange').attr('disabled', 'disabled')
                            } else {
                                $(optBarang).parents('.modal-body').find('.satuanAtasanForm').val(response.dataAtasan.id_satuan).change();
                                $(optBarang).parents('.modal-body').find('.qtyConvert').val(response.dataAtasan.konversi_turunan);
                                $(optBarang).parents('.modal-body').find('.qtyAtasanNow').text('Kuantitas saat ini: ' + response.dataAtasan.kuantitas);
                                $(optBarang).parents('.modal-body').find('input#qtyNowAtasanHidden').val(response.dataAtasan.kuantitas);
                                if (response.dataAtasan.kuantitas == 0) {
                                    $(optBarang).parents('.modal-body').find('.qtyExchange').attr('disabled', 'disabled')
                                } else {
                                    $(optBarang).parents('.modal-body').find('.qtyExchange').removeAttr('disabled')
                                }
                            }
                        }

                        //process success
                        $('.progress').find('.progress-bar').css('width', '100%');
                        $('.progress').hide(500)

                    },
                    error: function(err, status, errthrow) {
                        console.log(status);
                        $('.progress').find('.progress-bar').removeClass('bg-primary').addClass('bg-danger').css('width', '100%').text(errthrow);
                        $('.progress').hide(5000)
                    }
                });
            });

            $('.qtyExchange').keypress(function(e) {
                // code from this link, thankyou so much
                // StackOverflow: https://stackoverflow.com/questions/23156249/how-to-apply-regular-expression-to-input-using-jquery

                var test = /[0-9]/; //regex (only number)
                var value = String.fromCharCode(e.keyCode); //get the charcode and convert to char
                if (!value.match(test)) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false; //dont display key if it is a number
                }
                let valGabung = $(this).val();
                valGabung = parseInt(valGabung + value);
                let qtyNow = $(this).parents('.modal-body').find('input#qtyNowAtasanHidden').val();
                qtyNow = parseInt(qtyNow);
                if (valGabung > qtyNow) {
                    e.preventDefault();
                    e.stopPropagation();

                    Swal.fire({
                        titleText: 'Tidak dapat menambah kuantitas isian',
                        text: 'Inputan anda melebihi kuantitas pada satuan atasan anda',
                        icon: 'error'
                    })
                    return false;
                }
            }).keyup(function(e) {
                e.preventDefault();

                let val = $(this).val();
                if (val == '') {
                    $(this).parents('.modal-body').find('.qtyConvertPlusExistingSmallText').text('Pilih Satu dari Satuan diatas');
                    $(this).parents('.modal-body').find('.qtyConvertPlusExisting').val('');
                    $('.btnSubmitKonversiBarang').hide(500);
                    return false;
                }

                let konversi = $(this).parents('.modal-body').find('.qtyConvert').val();
                let qtyNow = $(this).parents('.modal-body').find('input#qtyNowHidden').val();

                val = parseInt(val);
                konversi = parseInt(konversi);
                qtyNow = parseInt(qtyNow);
                let result = (val * konversi + qtyNow);

                $(this).parents('.modal-body').find('.qtyConvertPlusExisting').val(result);
                $(this).parents('.modal-body').find('.qtyConvertPlusExistingSmallText').text('' + qtyNow + ' + (' + konversi + ' x ' + val + ') = ' + result);
                $('.btnSubmitKonversiBarang').show(500);

            });

            $('select.select2-modaltdb').select2({
                theme: "bootstrap",
                width: "auto",
                dropdownAutoWidth: true,
                dropdownParent: $('div.modal#modalCreateDetailBarang')
            });
            $('select.select2-modalkonvbar').select2({
                theme: "bootstrap",
                width: "auto",
                dropdownAutoWidth: true,
                dropdownParent: $('div.modal#modalKonversiKuantitas')
            });

            $('select.select2-modaltdb#turunanSatuan').change(function(e) {
                e.preventDefault();
                let val = $(e.target).val();
                val = parseInt(val);
                console.log(val);
                if (val === 0) {
                    // console.log('added');
                    $(this).parents('div.modal-body').find('input#konversiTurunan').attr('readonly', 'readonly');
                } else {
                    // console.log('removed');
                    $(this).parents('div.modal-body').find('input#konversiTurunan').removeAttr('readonly');
                }

            });
        });
    </script>
</div>

<?= $this->endSection(); ?>