<?php

use CodeIgniter\I18n\Time;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang Keluar</title>
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
    </style>
</head>

<body>
    <img src="<?= base_url() . "/assets/images/logo-itats.png"; ?>" alt="ITATS Logo">
    <hr style="clear: right">
    <h3>Detail Barang Keluar</h3>

    <table style="width: 50%; text-align: left; margin-bottom: 20px;">
        <tbody>
            <tr>
                <td>Oleh</td>
                <td>: <?= $data['nama_user']; ?></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: <?= Time::parse($data['tanggal_keluar'])->toLocalizedString("d MMMM yyyy - HH:mm") ?></td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>: <?= $data['nama_unit_kerja']; ?></td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: <?= ($data['status'] == 0) ? 'PROSES' : 'SELESAI'; ?></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;" class="detailBarang">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>Kuantitas</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($daftarBarangKeluar as $dbk) : ?>
                <tr>
                    <td><?= $no++; ?>.</td>
                    <td><?= $dbk['nama_barang']; ?></td>
                    <td><?= $dbk['nama_satuan']; ?></td>
                    <td><?= $dbk['kuantitas']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>