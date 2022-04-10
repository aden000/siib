<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Referensi</title>
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
            <h3>Pelaporan Referensi: <?= $d['nama_referensi'] ?></h3>
            <table style="width: 100%;" class="detailBarang">
                <thead>
                    <tr>
                        <?php if ($d['ref'] == '1') : //Kategori Barang 
                        ?>
                            <th>No</th>
                            <th>Nama Kategori Barang</th>
                        <?php elseif ($d['ref'] == '2') : //Unit Kerja 
                        ?>
                            <th>No</th>
                            <th>Nama Unit Kerja</th>
                        <?php elseif ($d['ref'] == '3') : //Vendor 
                        ?>
                            <th>No</th>
                            <th>Nama Vendor / Perusahaan</th>
                        <?php elseif ($d['ref'] == '4') : //Semester 
                        ?>
                            <th>No</th>
                            <th>Semester-ke</th>
                            <th>Tahun</th>
                        <?php elseif ($d['ref'] == '5') : //Satuan 
                        ?>
                            <th>No</th>
                            <th>Nama Satuan</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($d['data'] as $key => $dlist) : ?>
                        <tr>
                            <?php if ($d['ref'] == '1') : //Kategori Barang 
                            ?>
                                <td><?= $key + 1; ?></td>
                                <td><?= $dlist['nama_kategori_barang']; ?></td>
                            <?php elseif ($d['ref'] == '2') : //Unit Kerja 
                            ?>
                                <td><?= $key + 1; ?></td>
                                <td><?= $dlist['nama_unit_kerja']; ?></td>
                            <?php elseif ($d['ref'] == '3') : //Vendor 
                            ?>
                                <td><?= $key + 1; ?></td>
                                <td><?= $dlist['nama_vendor']; ?></td>
                            <?php elseif ($d['ref'] == '4') : //Semester 
                            ?>
                                <td><?= $key + 1; ?></td>
                                <td><?= $dlist['semester_ke']; ?></td>
                                <td><?= $dlist['tahun']; ?></td>
                            <?php elseif ($d['ref'] == '5') : //Satuan 
                            ?>
                                <td><?= $key + 1; ?></td>
                                <td><?= $dlist['nama_satuan']; ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
</body>

</html>