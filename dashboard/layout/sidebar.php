<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-text mx-3">
            <img src="<?= $base_url ?>assets/img/logo_sixteenmart.png" alt="HTML5 Icon" style="width:100px;height:70px;">
        </div>
    </a>

    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Master
    </div>
    <?php if ($_SESSION['access'] == 1) : ?>
        <li class="nav-item">
            <a class="nav-link" href="<?= $base_url ?>dashboard/users">
                <i class="fas fa-fw fa-users"></i>
                <span>Pengguna</span></a>
        </li>
    <?php endif; ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>dashboard/barang">
            <i class="fas fa-fw fa-table"></i>
            <span>Barang</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>dashboard/kategori">
            <i class="fas fa-fw fa-table"></i>
            <span>Kategori</span></a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Transaksi
    </div>
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>dashboard/masuk">
            <i class="fas fa-fw fa-truck"></i>
            <span>Barang Masuk</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>dashboard/keluar">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Barang Keluar</span></a>
    </li>

    <hr class="sidebar-divider d-none d-md-block my-0">
    <li class="nav-item">
        <a class="nav-link" href="<?= $base_url ?>logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Keluar</span></a>
    </li>

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>