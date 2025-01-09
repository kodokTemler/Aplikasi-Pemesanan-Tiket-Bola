<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || !isset($_SESSION['nama']) || !isset($_SESSION['email']) || !isset($_SESSION['no_hp']) || !isset($_SESSION['alamat'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href = '../index.php';
          </script>";
    exit;
}

// Cek apakah role adalah admin
if ($_SESSION['role'] !== 'admin') {
    echo "<script>
            alert('Akses ditolak! Halaman ini hanya untuk admin.');
            window.location.href = '../index.php'; // Redirect ke halaman user jika role bukan admin
          </script>";
    exit;
}

$active = 'index';
// Memastikan bahwa $_GET['active'] aman dari XSS dengan htmlspecialchars dan validasinya dengan in_array
if (isset($_GET['active']) && in_array($_GET['active'], ['daftarUsers', 'daftarEvent', 'daftarTiket', 'daftarPemesanan', 'daftarPembayaran'])) {
    $active = htmlspecialchars($_GET['active']);
}
?>

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo">
                <img
                    src="assets/img/logoTiket.png"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="60" />
                <p class="h5 fw-bold text-decoration-none text-white">Tiket <span class="text-warning">Yzp</span></p>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item <?= $active == 'index' ? 'active' : '' ?>">
                    <a href="index.php?active=index">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Components</h4>
                </li>
                <li class="nav-item <?= $active == 'daftarUsers' ? 'active' : '' ?>">
                    <a href="daftarUsers.php?active=daftarUsers">
                        <i class="fas fa-user-check"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item <?= $active == 'daftarEvent' ? 'active' : '' ?>">
                    <a href="daftarEvent.php?active=daftarEvent">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Event</p>
                    </a>
                </li>
                <li class="nav-item <?= $active == 'daftarTiket' ? 'active' : '' ?>">
                    <a href="daftarTiket.php?active=daftarTiket">
                        <i class="fas fa-ticket-alt"></i>
                        <p>Tiket</p>
                    </a>
                </li>
                <li class="nav-item <?= $active == 'daftarPemesanan' ? 'active' : '' ?>">
                    <a href="daftarPemesanan.php?active=daftarPemesanan">
                        <i class="fas fa-credit-card"></i>
                        <p>Daftar Pemesanan</p>
                    </a>
                </li>
                <li class="nav-item <?= $active == 'daftarPembayaran' ? 'active' : '' ?>">
                    <a href="daftarPembayaran.php?active=daftarPembayaran">
                        <i class="fas fa-calculator"></i>
                        <p>Daftar Pembayaran</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>