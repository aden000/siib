<?= $this->extend('Template/Admin/TemplateLTE'); ?>
<?= $this->section('content'); ?>
<div class="container pt-2">
    <div class="row">
        <div class="col">
            <div class="mx-lg-4 p-2 shadow border border-info rounded bg-white">
                <div class="table-responsive p-1">
                    <table id="loglist" class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Yang Melakukan</th>
                                <th>Keterangan Aktifitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            // d($katbarlist);
                            foreach ($logList as $log) : ?>
                                <tr>
                                    <td scope="row"><?= $no++; ?></td>
                                    <td><?= $log['nama_user']; ?></td>
                                    <td><?= $log['keterangan_aktifitas']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>