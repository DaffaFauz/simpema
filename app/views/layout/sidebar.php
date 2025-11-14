<!-- Sidebar -->
<?php 
    // Ambil path URL sekarang
    $current_page = $_SERVER['REQUEST_URI'];
?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASE_URL ?>/Dashboard">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIMPEMA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= strpos($current_page, '/Dashboard') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= BASE_URL ?>/Dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <?php if($data['user'] === 'Pembimbing'){ ?>

        <!-- Heading -->
        <div class="sidebar-heading">Addons</div>

        <li class="nav-item <?= strpos($current_page, '/Dokumen') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= BASE_URL ?>/Dokumen/">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Dokumen Mahasiswa</span>
            </a>
        </li>

    <?php } else if($data['user'] === 'Kaprodi'){ ?>

        <!-- Heading -->
        <div class="sidebar-heading">Dokumen</div>

        <li class="nav-item <?= strpos($current_page, '/Dokumen') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= BASE_URL ?>/Dokumen/">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Dokumen Mahasiswa</span>
            </a>
        </li>

    <?php } else if($data['user'] === 'LPPM'){ ?>

        <!-- Heading -->
        <div class="sidebar-heading">Data Master</div>

        <!-- Nav Item - Dosen Collapse Menu -->
        <?php 
            $isDosenActive = strpos($current_page, '/Dosen') !== false 
                             || strpos($current_page, '/Pembimbing') !== false 
                             || strpos($current_page, '/Kaprodi') !== false;
        ?>
        <li class="nav-item <?= $isDosenActive ? 'active' : '' ?>">
            <a class="nav-link <?= $isDosenActive ? '' : 'collapsed' ?>" href="#" 
                data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="<?= $isDosenActive ? 'true' : 'false' ?>" 
                aria-controls="collapsePages">
                <i class="fas fa-fw fa-user"></i>
                <span>Dosen</span>
            </a>
            <div id="collapsePages" class="collapse <?= $isDosenActive ? 'show' : '' ?>" 
                aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Dosen:</h6>
                    <a class="collapse-item <?= strpos($current_page, '/Dosen') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/Dosen">Dosen</a>
                    <a class="collapse-item <?= strpos($current_page, '/Pembimbing') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/Pembimbing">Pembimbing</a>
                    <a class="collapse-item <?= strpos($current_page, '/Kaprodi') !== false ? 'active' : '' ?>" href="<?= BASE_URL ?>/Kaprodi">Kaprodi</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Fakultas -->
        <li class="nav-item <?= strpos($current_page, '/Fakultas') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= BASE_URL ?>/Fakultas/">
                <i class="fas fa-fw fa-graduation-cap"></i>
                <span>Fakultas</span>
            </a>
        </li>

        <!-- Nav Item - Prodi -->
        <li class="nav-item <?= strpos($current_page, '/Prodi') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= BASE_URL ?>/Prodi/">
                <i class="fas fa-fw fa-book-open"></i>
                <span>Prodi</span>
            </a>
        </li>

        <!-- Nav Item - Periode -->
        <li class="nav-item <?= strpos($current_page, '/Periode') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= BASE_URL ?>/Periode/">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Periode</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">Dokumen</div>

        <!-- Nav Item - Dokumen Mahasiswa -->
        <li class="nav-item <?= strpos($current_page, '/Dokumen/') !== false && strpos($current_page, '/pengajuan') === false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= BASE_URL ?>/Dokumen/">
                <i class="fas fa-fw fa-folder"></i>
                <span>Dokumen Mahasiswa</span>
            </a>
        </li>

        <!-- Nav Item - Dokumen Pengajuan -->
        <li class="nav-item <?= strpos($current_page, '/Dokumen/pengajuan') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= BASE_URL ?>/Dokumen/pengajuan">
                <i class="fas fa-fw fa-folder"></i>
                <span>Dokumen Pengajuan</span>
            </a>
        </li>

    <?php } ?>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
