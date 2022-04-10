<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($judul) ? 'SIIB - ' . $judul : "\$judul wasn't given, give me in view() in your controller"; ?></title>
    <?= $this->include('Template/Admin/HeadLTE'); ?>
</head>

<body style="background-color: #eee;" class="sb-nav-fixed">
    <?php if (session('info')) : ?>
        <div class="flash-data" data-judul="<?= session('info')['judul']; ?>" data-msg="<?= session('info')['msg']; ?>" data-role="<?= session('info')['role']; ?>">
        </div>
    <?php endif; ?>
    <?= $this->include('Admin/Navbar'); ?>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <?= $this->include('Admin/Sidebar'); ?>
        </div>
        <div id="layoutSidenav_content">
            <?= $this->renderSection('content'); ?>
        </div>
    </div>
    <?= $this->include('Template/Admin/JSLTE'); ?>
    <!-- Additional JS Script -->
    <script>
        var element = document.querySelector('.flash-data');
        if (element) {
            Swal.fire(
                element.getAttribute('data-judul'),
                element.getAttribute('data-msg'),
                element.getAttribute('data-role')
            );
        }
    </script>
</body>

</html>