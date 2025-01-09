<?php
include '../controllers/koneksi.php';

// Query untuk menghitung jumlah User
$userQuery = "SELECT COUNT(*) AS total_user FROM tb_user";
$userResult = mysqli_query($koneksi, $userQuery);
$userCount = mysqli_fetch_assoc($userResult)['total_user'];

// Query untuk menghitung jumlah Tiket
$tiketQuery = "SELECT COUNT(*) AS total_tiket FROM tb_tiket";
$tiketResult = mysqli_query($koneksi, $tiketQuery);
$tiketCount = mysqli_fetch_assoc($tiketResult)['total_tiket'];

// Query untuk menghitung jumlah Event
$eventQuery = "SELECT COUNT(*) AS total_event FROM tb_event";
$eventResult = mysqli_query($koneksi, $eventQuery);
$eventCount = mysqli_fetch_assoc($eventResult)['total_event'];

// Query untuk menghitung jumlah Pemesanan
$pemesananQuery = "SELECT COUNT(*) AS total_pemesanan FROM tb_pemesanan";
$pemesananResult = mysqli_query($koneksi, $pemesananQuery);
$pemesananCount = mysqli_fetch_assoc($pemesananResult)['total_pemesanan'];

// Query untuk menghitung jumlah Pembayaran
$pembayaranQuery = "SELECT COUNT(*) AS total_pembayaran FROM tb_pembayaran";
$pembayaranResult = mysqli_query($koneksi, $pembayaranQuery);
$pembayaranCount = mysqli_fetch_assoc($pembayaranResult)['total_pembayaran'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>Dashboard</title>
  <!-- Link CSS -->
  <?php
  include 'components/link.php';
  ?>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php
    require 'components/sidebar.php';
    ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <!-- Header -->
      <?php
      require 'components/header.php';
      ?>

      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
              <h6 class="op-7 mb-2">Selamat Datang, <?= $_SESSION['nama'] ?></h6>
            </div>
          </div>

          <div class="row">
            <!-- Card Jumlah User -->
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-user-check"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Jumlah User</p>
                        <h4 class="card-title"><?php echo $userCount; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card Jumlah Tiket -->
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-info bubble-shadow-small">
                        <i class="fas fa-ticket-alt"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Jumlah Tiket</p>
                        <h4 class="card-title"><?php echo $tiketCount; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card Jumlah Event -->
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-success bubble-shadow-small">
                        <i class="fas fa-calendar-alt"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Jumlah Event</p>
                        <h4 class="card-title"><?php echo $eventCount; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card Jumlah Pemesanan -->
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-secondary bubble-shadow-small">
                        <i class="fas fa-shopping-cart"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Jumlah Pemesanan</p>
                        <h4 class="card-title"><?php echo $pemesananCount; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Card Jumlah Pembayaran -->
            <div class="col-sm-6 col-md-3">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-warning bubble-shadow-small">
                        <i class="fas fa-credit-card"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Jumlah Pembayaran</p>
                        <h4 class="card-title"><?php echo $pembayaranCount; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <?php
      require 'components/footer.php';
      ?>
    </div>

    <!-- Custom template -->
    <?php
    require 'components/settings.php';
    ?>
    <!-- End Custom template -->

  </div>

  <!-- Core JS Files -->
  <?php
  require 'components/script.php';
  ?>
</body>

</html>