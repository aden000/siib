<?php

use Codeigniter\I18n\Time;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        Pelaporan Barang Keluar
    </title>
    <style>
        @font-face {
            font-family: 'Open Sans';
            font-style: normal;
            font-weight: normal;
            src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
        }

        @font-face {
            font-family: 'Open Sans Bold';
            font-style: normal;
            font-weight: bold;
            src: url(https://fonts.googleapis.com/css2?family=Open+Sans:wght@700&display=swap) format('truetype');
        }

        body {
            font-family: "Open Sans", sans-serif;
        }

        img {
            float: right;
        }

        table {
            border-collapse: collapse;
        }

        table.detailBarang thead th,
        table.detailBarang tbody td {
            border: 1px solid black;
            text-align: left;
        }

        thead,
        h3 {
            font-family: 'Open Sans Bold', sans-serif;
            font-weight: bold;
        }

        .content-page {
            page-break-after: always;
        }

        .content-page:last-child {
            page-break-after: avoid;
        }
    </style>
</head>

<body>
    <?php foreach ($data as $key => $d) : ?>
        <div class="content-page">
            <img src="<?= base_url() . "/assets/images/logo-itats.png"; ?>" alt="ITATS Logo">
            <hr style="clear: right">
            <h3>Pelaporan Barang Keluar</h3>
            <table style="width: 50%; text-align: left; margin-bottom: 20px;">
                <tbody>
                    <tr>
                        <td>Oleh</td>
                        <td>: <?= $d['barang_keluar']['nama_user']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: <?= Time::parse($d['barang_keluar']['tanggal_keluar'])->toLocalizedString("d MMMM yyyy - HH:mm") ?></td>
                    </tr>
                    <tr>
                        <td>Unit Kerja</td>
                        <td>: <?= $d['barang_keluar']['nama_unit_kerja']; ?></td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 100%;" class="detailBarang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Kuantitas</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($d['detail_barang_keluar'])) : ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">Tiada data detail barang</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($d['detail_barang_keluar'] as $key => $db) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $db['nama_barang']; ?></td>
                                <td><?= $db['kuantitas']; ?></td>
                                <td><?= $db['nama_satuan']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</body>

</html>