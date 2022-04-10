<!doctype html>
<html lang="en">

<head>
    <title><?= isset($judul) ? $judul : "\$judul wasn't given, give me in view() in your controller"; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <?= $this->include('Template/Head'); ?>
</head>

<body style="background-color: #eee;">
    <?php if (session('info')) : ?>
        <div class="flash-data" data-judul="<?= session('info')['judul']; ?>" data-msg="<?= session('info')['msg']; ?>" data-role="<?= session('info')['role']; ?>">
        </div>
    <?php endif; ?>
    <?= $this->renderSection('content'); ?>
    <?= $this->include('Template/Footer'); ?>
    <!-- Additional JS Script -->
    <script>
        var element = document.querySelector('.flash-data');
        if (element) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
            })

            Toast.fire({
                titleText: element.getAttribute('data-judul'),
                text: element.getAttribute('data-msg'),
                icon: element.getAttribute('data-role')
            });
        }
    </script>
</body>

</html>