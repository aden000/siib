<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Barang</title>
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
            <h3>Pelaporan Barang: <?= $d['barang']['nama_barang']; ?></h3>
            <table style="width: 100%;" class="detailBarang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Satuan</th>
                        <th>Kuantitas</th>
                        <th>Satuan Turunan</th>
                        <th>Konversi Turunan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($d['detail_barang'])) : ?>
                        <tr>
                            <td colspan="5" style="text-align: center;">Tiada data detail barang</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($d['detail_barang'] as $key => $db) : ?>
                            <tr>
                                <td><?= $key + 1; ?></td>
                                <td><?= $db['nama_satuan']; ?></td>
                                <td><?= $db['kuantitas']; ?></td>
                                <td><?= is_null($db['nama_turunan_satuan']) ? 'Tidak ada (Satuan terkecil)' : $db['nama_turunan_satuan']; ?></td>
                                <td><?= $db['konversi_turunan']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</body>

</html>