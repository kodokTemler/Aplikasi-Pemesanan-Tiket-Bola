<?php
// Koneksi ke database
include '../controllers/crudTiket.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <!-- Fonts and icons -->
    <script src="assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["assets/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="assets/css/demo.css" />
</head>

<body>
    <div class="wrapper">
        <?php include 'components/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'components/header.php'; ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Manajemen Tiket</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="index.php"><i class="icon-home"></i></a>
                            </li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item"><a href="daftarTiket.php?active=daftarTiket">Tiket</a></li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="card-title">Tabel Tiket</div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTiketModal">
                                        <i class="fa fa-plus"></i> Add Tiket
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Event</th>
                                                    <th scope="col">Kategori</th>
                                                    <th scope="col">Harga</th>
                                                    <th scope="col">Stok</th>
                                                    <th scope="col" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Ambil data dari tabel tb_tiket
                                                $sql = "SELECT t.id_tiket, t.id_event, t.kategori_tiket, t.harga_tiket, t.stok_tiket, e.nama_event FROM tb_tiket t JOIN tb_event e ON t.id_event = e.id_event";
                                                $result = mysqli_query($koneksi, $sql);
                                                $no = 1;

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $id_tiket = $row['id_tiket'];
                                                    $nama_event = $row['nama_event'];
                                                    $kategori_tiket = $row['kategori_tiket'];
                                                    $harga_tiket = $row['harga_tiket'];
                                                    $stok_tiket = $row['stok_tiket'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $nama_event; ?></td>
                                                        <td><?= $kategori_tiket; ?></td>
                                                        <td>Rp<?= number_format($harga_tiket, 0, ',', '.'); ?></td>
                                                        <td><?= $stok_tiket; ?></td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <button class="btn btn-link btn-primary" data-bs-toggle="modal" data-bs-target="#editTiketModal<?= $id_tiket; ?>"><i class="fa fa-edit"></i></button>
                                                                <button class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#deleteTiketModal<?= $id_tiket; ?>"><i class="fa fa-times"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="editTiketModal<?= $id_tiket; ?>" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Tiket</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="" method="post">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_tiket" value="<?= $id_tiket; ?>">
                                                                        <div class="mb-3">
                                                                            <label for="id_event" class="form-label">Event</label>
                                                                            <select name="id_event" id="id_event" class="form-control" required>
                                                                                <?php
                                                                                // Ambil data event
                                                                                $event_sql = "SELECT * FROM tb_event";
                                                                                $event_result = mysqli_query($koneksi, $event_sql);
                                                                                while ($event = mysqli_fetch_assoc($event_result)) {
                                                                                    $selected = $event['id_event'] == $row['id_event'] ? 'selected' : '';
                                                                                    echo "<option value='{$event['id_event']}' {$selected}>{$event['nama_event']}</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="kategori_tiket" class="form-label">Kategori Tiket</label>
                                                                            <select name="kategori_tiket" id="kategori_tiket" class="form-control" required>
                                                                                <option value="VVIP" <?= $kategori_tiket == 'VVIP' ? 'selected' : ''; ?>>VVIP</option>
                                                                                <option value="VIP" <?= $kategori_tiket == 'VIP' ? 'selected' : ''; ?>>VIP</option>
                                                                                <option value="Ekonomi" <?= $kategori_tiket == 'Ekonomi' ? 'selected' : ''; ?>>Ekonomi</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="harga_tiket" class="form-label">Harga Tiket</label>
                                                                            <input type="number" name="harga_tiket" id="harga_tiket" class="form-control" value="<?= $harga_tiket; ?>" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="stok_tiket" class="form-label">Stok Tiket</label>
                                                                            <input type="number" name="stok_tiket" id="stok_tiket" class="form-control" value="<?= $stok_tiket; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" name="editTiket" class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Delete -->
                                                    <div class="modal fade" id="deleteTiketModal<?= $id_tiket; ?>" tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Hapus Tiket</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="" method="post">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_tiket" value="<?= $id_tiket; ?>">
                                                                        <p>Apakah Anda yakin ingin menghapus tiket <strong><?= $nama_event; ?></strong>?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" name="deleteTiket" class="btn btn-danger">Hapus</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Tambah Tiket -->
            <div class="modal fade" id="addTiketModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Tiket</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="id_event" class="form-label">Event</label>
                                    <select name="id_event" id="id_event" class="form-control" required>
                                        <?php
                                        // Ambil data event
                                        $event_sql = "SELECT * FROM tb_event";
                                        $event_result = mysqli_query($koneksi, $event_sql);
                                        while ($event = mysqli_fetch_assoc($event_result)) {
                                            echo "<option value='{$event['id_event']}'>{$event['nama_event']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="kategori_tiket" class="form-label">Kategori Tiket</label>
                                    <select name="kategori_tiket" id="kategori_tiket" class="form-control" required>
                                        <option value="">- Pilih -</option>
                                        <option value="VVIP">VVIP</option>
                                        <option value="VIP">VIP</option>
                                        <option value="Ekonomi">Ekonomi</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="harga_tiket" class="form-label">Harga Tiket</label>
                                    <input type="number" name="harga_tiket" id="harga_tiket" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="stok_tiket" class="form-label">Stok Tiket</label>
                                    <input type="number" name="stok_tiket" id="stok_tiket" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="addTiket" class="btn btn-primary">Tambah Tiket</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php require 'components/footer.php'; ?>
            <!-- Custom template -->
            <?php require 'components/settings.php'; ?>
        </div>
        <!--   Core JS Files   -->
        <script src="assets/js/core/jquery-3.7.1.min.js"></script>
        <script src="assets/js/core/popper.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>

        <!-- jQuery Scrollbar -->
        <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
        <!-- Datatables -->
        <script src="assets/js/plugin/datatables/datatables.min.js"></script>
        <!-- Kaiadmin JS -->
        <script src="assets/js/kaiadmin.min.js"></script>
        <!-- Kaiadmin DEMO methods, don't include it in your project! -->
        <script src="assets/js/setting-demo2.js"></script>
        <script>
            $(document).ready(function() {
                $("#basic-datatables").DataTable({});

                $("#multi-filter-select").DataTable({
                    pageLength: 5,
                    initComplete: function() {
                        this.api()
                            .columns()
                            .every(function() {
                                var column = this;
                                var select = $(
                                        '<select class="form-select"><option value=""></option></select>'
                                    )
                                    .appendTo($(column.footer()).empty())
                                    .on("change", function() {
                                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                        column
                                            .search(val ? "^" + val + "$" : "", true, false)
                                            .draw();
                                    });

                                column
                                    .data()
                                    .unique()
                                    .sort()
                                    .each(function(d, j) {
                                        select.append(
                                            '<option value="' + d + '">' + d + "</option>"
                                        );
                                    });
                            });
                    },
                });

                // Add Row
                $("#add-row").DataTable({
                    pageLength: 5,
                });

                var action =
                    '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

                $("#addRowButton").click(function() {
                    $("#add-row")
                        .dataTable()
                        .fnAddData([
                            $("#addName").val(),
                            $("#addPosition").val(),
                            $("#addOffice").val(),
                            action,
                        ]);
                    $("#addRowModal").modal("hide");
                });
            });
        </script>
</body>

</html>