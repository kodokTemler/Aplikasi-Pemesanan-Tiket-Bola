<?php
include '../controllers/crudPembayaran.php'; // Include file untuk koneksi dan operasi CRUD
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
        <?php require 'components/sidebar.php'; ?>
        <div class="main-panel">
            <?php require 'components/header.php'; ?>

            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Data Pembayaran</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="index.php"><i class="icon-home"></i></a>
                            </li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item"><a href="daftarPembayaran.php?active=daftarPembayaran">Data Pembayaran</a></li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Daftar Pembayaran</div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Pemesanan</th>
                                                    <th scope="col">Metode Pembayaran</th>
                                                    <th scope="col">Bukti Pembayaran</th>
                                                    <th scope="col">Status Pembayaran</th>
                                                    <th scope="col">Tanggal Pembayaran</th>
                                                    <th scope="col" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Query untuk menampilkan pembayaran dan nama pemesanan dari tabel tb_user
                                                $pembayaranSql = "SELECT p.id_pembayaran, u.nama AS nama_pemesanan, p.metode_pembayaran, p.bukti_pembayaran, p.status_pembayaran, p.tanggal_pembayaran
                                                              FROM tb_pembayaran p
                                                              JOIN tb_pemesanan ps ON p.id_pemesanan = ps.id_pemesanan
                                                              JOIN tb_user u ON ps.id_user = u.id_user";
                                                $pembayaranRes = mysqli_query($koneksi, $pembayaranSql);
                                                $no = 1;

                                                // Menampilkan data pembayaran
                                                while ($row = mysqli_fetch_assoc($pembayaranRes)) {
                                                    $id_pembayaran = $row['id_pembayaran'];
                                                    $nama_pemesanan = $row['nama_pemesanan'];
                                                    $metode_pembayaran = $row['metode_pembayaran'];
                                                    $bukti_pembayaran = $row['bukti_pembayaran'];
                                                    $status_pembayaran = $row['status_pembayaran'];
                                                    $tanggal_pembayaran = $row['tanggal_pembayaran'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $nama_pemesanan ?></td>
                                                        <td><?= $metode_pembayaran ?></td>
                                                        <td><img src="uploads/bukti/<?= $bukti_pembayaran ?>" alt="Bukti Pembayaran" width="100"></td>
                                                        <td><?= $status_pembayaran ?></td>
                                                        <td><?= $tanggal_pembayaran ?></td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <!-- Button Detail -->
                                                                <button class="btn btn-link btn-info" data-bs-toggle="modal" data-bs-target="#detailModal<?= $id_pembayaran; ?>">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>

                                                                <!-- Button Edit -->
                                                                <button class="btn btn-link btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?= $id_pembayaran; ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>

                                                                <!-- Button Delete -->
                                                                <button class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $id_pembayaran; ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Detail Pembayaran -->
                                                    <div class="modal fade" id="detailModal<?= $id_pembayaran; ?>" tabindex="-1" aria-labelledby="detailModalLabel<?= $id_pembayaran; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="detailModalLabel<?= $id_pembayaran; ?>">Detail Pembayaran</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p><strong>ID Pembayaran:</strong> <?= $id_pembayaran; ?></p>
                                                                    <p><strong>Nama Pemesanan:</strong> <?= $nama_pemesanan; ?></p>
                                                                    <p><strong>Metode Pembayaran:</strong> <?= $metode_pembayaran; ?></p>
                                                                    <p><strong>Status Pembayaran:</strong> <?= $status_pembayaran; ?></p>
                                                                    <p><strong>Tanggal Pembayaran:</strong> <?= $tanggal_pembayaran; ?></p>
                                                                    <p><strong>Bukti Pembayaran:</strong></p>
                                                                    <img src="uploads/bukti/<?= $bukti_pembayaran ?>" alt="Bukti Pembayaran" width="300">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Edit Pembayaran -->
                                                    <div class="modal fade" id="editModal<?= $id_pembayaran; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $id_pembayaran; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel<?= $id_pembayaran; ?>">Edit Pembayaran</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="" method="POST">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_pembayaran" value="<?= $id_pembayaran; ?>">

                                                                        <div class="mb-3">
                                                                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                                                                            <input type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran" value="<?= htmlspecialchars($metode_pembayaran); ?>" readonly>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                                                                            <select class="form-control" id="status_pembayaran" name="status_pembayaran" required>
                                                                                <option value="Pending" <?= $status_pembayaran == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                                                <option value="Sukses" <?= $status_pembayaran == 'Sukses' ? 'selected' : ''; ?>>Sukses</option>
                                                                                <option value="Dibatalkan" <?= $status_pembayaran == 'Dibatalkan' ? 'selected' : ''; ?>>Dibatalkan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                        <button type="submit" class="btn btn-primary" name="edit_pembayaran">Simpan Perubahan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <!-- Modal untuk Konfirmasi Hapus -->
                                                    <div class="modal fade" id="deleteModal<?= $id_pembayaran; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $id_pembayaran; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel<?= $id_pembayaran; ?>">Konfirmasi Penghapusan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form action="" method="POST">
                                                                    <input type="hidden" name="id_pembayaran" value="<?= $id_pembayaran ?>">
                                                                    <div class="modal-body">
                                                                        <p>Apakah Anda yakin ingin menghapus pembayaran <strong><?= $nama_pemesanan; ?></strong>?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" class="btn btn-danger" name="hapus_pembayaran">Hapus</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                    </div>
                                <?php
                                                }
                                ?>
                                </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require 'components/footer.php'; ?>
    </div>
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