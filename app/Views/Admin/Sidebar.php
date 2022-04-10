<!-- using adminlte3, see public/assets/css/alte3/css/adminlte.css -->
<!-- Sidebar Menu -->
<?php $url = current_url(true); ?>
<nav class="mt-2">
    <ul class="nav nav-pills nav-child-indent nav-sidebar text-sm flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">UTAMA</li>
        <li class="nav-item">
            <a href="<?= base_url() . route_to('admin.dashboard'); ?>" class="nav-link <?= $url->getSegment(2) == 'dashboard' ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-speedometer2"></i>
                <p>
                    Dashboard
                </p>
            </a>
        </li>
        <li class="nav-header">PUSAT MANAJEMEN</li>
        <?php if ($userdata['role'] == 1) : ?>
            <li class="nav-item <?= $url->getSegment(2) == 'users' ? 'menu-open' : 'menu-close'; ?>">
                <a href="<?= base_url() . route_to('admin.users.view'); ?>" class="nav-link <?= ($url->getSegment(2) == 'users') ? 'active' : ''; ?>">
                    <i class="nav-icon bi bi-people-fill"></i>
                    <p>
                        Manajemen User
                    </p>
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item <?= $url->getSegment(2) == 'kelola' ? 'menu-open' : 'menu-close'; ?>">
            <a href="#" class="nav-link <?= $url->getSegment(2) == 'kelola' ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-list-check"></i>
                <p>
                    Manajemen Referensi
                    <i class="right bi bi-caret-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url() . route_to('admin.kelola.kategoribarang'); ?>" class="nav-link <?= $url->getSegment(3) == 'kategori-barang' ? 'active' : ''; ?>">
                        <i class="bi bi-bookmarks-fill nav-icon"></i>
                        <p>Kategori Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() . route_to('admin.kelola.unitkerja'); ?>" class="nav-link <?= $url->getSegment(3) == 'unit-kerja' ? 'active' : ''; ?>">
                        <i class="bi bi-briefcase-fill nav-icon"></i>
                        <p>Unit Kerja</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() . route_to('admin.kelola.vendor'); ?>" class="nav-link <?= $url->getSegment(3) == 'vendor' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-building"></i>
                        <p>Vendor / Perusahaan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() . route_to('admin.kelola.semester'); ?>" class="nav-link <?= $url->getSegment(3) == 'semester' ? 'active' : ''; ?>">
                        <i class="bi bi-calendar-range nav-icon"></i>
                        <p>Semester</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() . route_to('admin.kelola.satuan'); ?>" class="nav-link <?= $url->getSegment(3) == 'satuan' ? 'active' : ''; ?>">
                        <i class="bi bi-boxes nav-icon"></i>
                        <p>Satuan</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item <?= $url->getSegment(2) == 'transaksi' ? 'menu-open' : 'menu-close'; ?>">
            <a href="#" class="nav-link <?= $url->getSegment(2) == 'transaksi' ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-box-seam"></i>
                <p>
                    Manajemen Barang
                    <i class="right bi bi-caret-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url() . route_to('admin.transaksi.barang'); ?>" class="nav-link <?= $url->getSegment(3) == 'barang' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-list-check"></i>
                        <p>Pengelolaan Barang</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() . route_to('admin.transaksi.barangmasuk'); ?>" class="nav-link <?= $url->getSegment(3) == 'barang-masuk' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-box-arrow-in-down"></i>
                        <p>Pengadaan Barang Masuk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url() . route_to('admin.transaksi.barangkeluar'); ?>" class="nav-link <?= $url->getSegment(3) == 'barang-keluar' ? 'active' : ''; ?>">
                        <i class="nav-icon bi bi-box-arrow-up"></i>
                        <p>Pengajuan Barang Keluar</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-header">PENCATATAN & PELAPORAN</li>
        <li class="nav-item">
            <a href="<?= base_url() . route_to('admin.pelaporan'); ?>" class="nav-link <?= $url->getSegment(2) == 'pelaporan' ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-file-earmark-text"></i>
                <p>
                    Manajemen Pelaporan
                </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url() . route_to('admin.logaktifitas'); ?>" class="nav-link <?= $url->getSegment(2) == 'log-aktifitas' ? 'active' : ''; ?>">
                <i class="nav-icon bi bi-check2"></i>
                <p>
                    Log Aktifitas
                </p>
            </a>
        </li>
    </ul>
</nav>
<!-- /.sidebar-menu -->