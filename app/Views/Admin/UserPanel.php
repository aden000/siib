<div class="row p-2 justify-content-center">
    <div class="col-auto ml-1">
        <i class="bi bi-person-circle"></i>
    </div>
    <div class="col">
        <div class="section-heading">
            <h6><?= $userdata['nama_user']; ?></h6>
            <span class="text-muted">Akses: <?php if ($userdata['role'] == 1) : ?>PSI<?php elseif ($userdata['role'] == 2) : ?>Bagian Keuangan<?php elseif ($userdata['role'] == 3) : ?>Yayasan<?php else : ?>Belum Terdefinisi<?php endif; ?></span>
        </div>
    </div>
</div>
<div class="dropdown-divider"></div>
<button type="button" class="dropdown-item" data-toggle="modal" data-target="#modalChangePass">
    <i class="bi bi-key-fill" title="Ganti Password"></i>&nbsp;Ganti Password
</button>
<form action="<?= base_url() . route_to('auth.logout'); ?>" method="post">
    <?= csrf_field(); ?>
    <button type="submit" class="dropdown-item" title="Keluar Sistem"><i class="bi bi-box-arrow-left"></i>&nbsp;Keluar Sistem</button>
</form>