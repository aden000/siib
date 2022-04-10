<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="bi bi-layout-text-sidebar"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right" style="min-width: 300px !important;">
                    <h6 class="dropdown-header">
                        User Menu
                    </h6>
                    <div class="dropdown-divider"></div>
                    <?= $this->include('Admin/UserPanel'); ?>
                </div>
            </div>
        </li>
    </ul>
</nav>
<!-- Modal Change Password -->
<div class="modal fade" id="modalChangePass" tabindex="-1" role="dialog" aria-labelledby="modalChangePassHelpID" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ganti Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url() . route_to('auth.changepass'); ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="oldpass">Password saat ini</label>
                        <input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="..." required>
                    </div>
                    <div class="form-group">
                        <label for="newpass">Password Baru</label>
                        <input type="password" class="form-control" name="newpass" id="newpass" placeholder="..." required>
                    </div>
                    <div class="form-group">
                        <label for="newpassconfirm">Ulangi Password Baru</label>
                        <input type="password" class="form-control" name="newpassconfirm" id="newpassconfirm" placeholder="..." required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="bi bi-x"></i>&nbsp;Close</button>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i>&nbsp;Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        if (localStorage.getItem('toggledarkmode') === null || localStorage.getItem('toggledarkmode') === 'no') {
            $('nav.navbar').find('i.bi').removeClass('bi-moon');
            $('body').removeClass('dark-mode');
        } else if (localStorage.getItem('toggledarkmode') === 'yes') {
            $('body').addClass('dark-mode');
            $('nav.navbar').find('i.bi').addClass('bi-moon');
        }
    });
    $('#toggledm').click(function(e) {
        e.preventDefault();
        if (localStorage.getItem('toggledarkmode') === null || localStorage.getItem('toggledarkmode') === 'no') {
            localStorage.setItem('toggledarkmode', 'yes')
            $(this).find('i.bi').removeClass('bi-sun');
            $('body').addClass('dark-mode');
            $(this).find('i.bi').addClass('bi-moon');
        } else if (localStorage.getItem('toggledarkmode') === 'yes') {
            localStorage.setItem('toggledarkmode', 'no')
            $(this).find('i.bi').removeClass('bi-moon');
            $('body').removeClass('dark-mode');
            $(this).find('i.bi').addClass('bi-sun');
        }
    });
</script>
<!-- /.navbar -->