<?= $this->extend('Template/Template'); ?>
<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <h4 class="mt-4">Selamat datang di Web Sistem Informasi Inventaris Barang</h4>
                <h6><span class="badge bg-primary">Dev version</span></h6>
            </div>
            <div class="row">
                <img src="/assets/images/Packaging-Product.jpg" alt="placeholderimg" class="rounded img-fluid">
                <p class="text-decoration-none"><small><a href="https://www.freevector.com/packaging-product-vector-29699#">Image source</a></small></p>
            </div>

        </div>
        <div class="col-md-6 my-auto d-block">
            <div class="card">
                <div class="card-header">
                    Login Sistem
                </div>
                <?php if (!session('LoggedInID')) : ?>
                    <form action="<?= base_url() . route_to("auth.login"); ?>" method="POST">
                        <div class="card-body">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="uname">Username</label>
                                <input type="text" class="form-control" name="uname" id="uname" aria-describedby="unameId" placeholder="Masukan Username">
                            </div>
                            <div class="form-group">
                                <label for="pword">Password</label>
                                <input type="password" class="form-control" name="pword" id="pword" placeholder="Masukan Password">
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </div>
                    </form>
                <?php else : ?>
                    <div class="card-body">
                        <h6>Anda masih mempunyai sesi, silahkan untuk menuju dashboard</h6>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col">
                                <a href="<?= base_url() . route_to('admin.dashboard'); ?>" role="button" class="btn btn-primary w-100">
                                    <i class="bi bi-speedometer2"></i>
                                    Dashboard
                                </a>
                            </div>
                            <div class="col">
                                <form action="<?= base_url() . route_to('auth.logout'); ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-box-arrow-left"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>


            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>