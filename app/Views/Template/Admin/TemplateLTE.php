<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($judul) ? 'SIIB - ' . $judul : "\$judul wasn't given, give me in view() in your controller"; ?></title>
    <?= $this->include('Template/Admin/HeadLTE'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php if (session('info')) : ?>
        <div class="flash-data" data-judul="<?= session('info')['judul']; ?>" data-msg="<?= session('info')['msg']; ?>" data-role="<?= session('info')['role']; ?>">
        </div>
    <?php endif; ?>
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="custom-preloader flex-column justify-content-center align-items-center"> -->
        <!-- <img class="animation__shake" src="/assets/alte3/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60"> -->
        <!-- <h1 class="animation__fade-in-fade-out">Sedang Memuat...</h1> -->
        <!-- </div> -->

        <?= $this->include('Admin/Navbar'); ?>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-info elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url() . route_to('admin.dashboard'); ?>" class="brand-link">
                <img src="/assets/alte3/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">SIIB</span>
                <!-- <h5 class="brand-text">SIIB</h5> -->
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->


                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <?= $this->include('Admin/Sidebar'); ?>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="container pt-2">
                <div class="row mx-2 section-heading">
                    <div class="col-auto d-flex align-items-center">
                        <h4>
                            <?= isset($judul) ? $judul : '$judul has\'t been setting, give me in your view'; ?>
                            <?php if (isset($subjudul)) : ?>
                                <br /><small><?= $subjudul; ?></small>
                            <?php endif; ?>
                        </h4>
                    </div>
                    <div class="col text-right">
                        <?php $no = 0;
                        $count = empty($breadcrumbs) ? 0 : count($breadcrumbs);
                        foreach ($breadcrumbs as $bread) : ?>
                            <?php $no++; ?>
                            <a href="<?= $bread['link']; ?>" role="button"><?= $bread['namelink']; ?></a>
                            <?= ($no < $count) ? '<span>/</span>' : ''; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?= $this->renderSection('content'); ?>
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; <?= date('Y'); ?> <a href="https://aaa.id">SIIB</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> <span class="badge badge-success">Development</span> | <b>Environment</b> <span class="badge badge-info"><?= strtoupper(ENVIRONMENT); ?></span>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?= $this->include('Template/Admin/JSLTE'); ?>
    <script>
        // $.widget.bridge('uibutton', $.ui.button)
        var element = document.querySelector('.flash-data');
        var isToast = element.getAttribute('data-toast');
        if (element) {
            if (isToast == 'true') {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timerProgressBar: true,
                    timer: 3000,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                })

                Toast.fire({
                    titleText: element.getAttribute('data-judul'),
                    html: element.getAttribute('data-msg'),
                    icon: element.getAttribute('data-role')
                });
            } else {
                Swal.fire({
                    titleText: element.getAttribute('data-judul'),
                    html: element.getAttribute('data-msg'),
                    icon: element.getAttribute('data-role')
                })
            }
        }
        // $(function() {
        //     $('.custom-preloader').fadeOut(1000);
        // });
    </script>
</body>

</html>