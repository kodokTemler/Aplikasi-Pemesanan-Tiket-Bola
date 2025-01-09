<?php
include '../controllers/crudPemesanan.php'; // Include file untuk koneksi dan operasi CRUD
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
                        <h3 class="fw-bold mb-3">Pemesanan Tiket</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="index.php"><i class="icon-home"></i></a>
                            </li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item"><a href="daftarPemesanan.php?active=daftarPemesanan">Pemesanan Tiket</a></li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Daftar Pemesanan</div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama User</th>
                                                    <th scope="col">Kategori Tiket</th>
                                                    <th scope="col">Jumlah Tiket</th>
                                                    <th scope="col">Total Harga</th>
                                                    <th scope="col">Status Pemesanan</th>
                                                    <th scope="col">Tanggal Pemesanan</th>
                                                    <th scope="col" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Query untuk menampilkan pemesanan
                                                $pemesananSql = "SELECT p.id_pemesanan, p.id_user, p.id_tiket, p.jumlah_tiket, p.total_harga, p.status_pemesanan, p.tanggal_pemesanan, u.nama, t.kategori_tiket 
                                                             FROM tb_pemesanan p 
                                                             JOIN tb_user u ON p.id_user = u.id_user 
                                                             JOIN tb_tiket t ON p.id_tiket = t.id_tiket";
                                                $pemesananRes = mysqli_query($koneksi, $pemesananSql);
                                                $no = 1;

                                                // Menampilkan data pemesanan
                                                while ($row = mysqli_fetch_assoc($pemesananRes)) {
                                                    $id_pemesanan = $row['id_pemesanan'];
                                                    $nama = $row['nama'];
                                                    $kategori_tiket = $row['kategori_tiket'];
                                                    $jumlah_tiket = $row['jumlah_tiket'];
                                                    $total_harga = $row['total_harga'];
                                                    $status_pemesanan = $row['status_pemesanan'];
                                                    $tanggal_pemesanan = $row['tanggal_pemesanan'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $nama ?></td>
                                                        <td><?= $kategori_tiket ?></td>
                                                        <td><?= $jumlah_tiket ?></td>
                                                        <td><?= "Rp " . number_format($total_harga, 0, ',', '.') ?></td>
                                                        <td><?= $status_pemesanan ?></td>
                                                        <td><?= $tanggal_pemesanan ?></td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <!-- Button Edit -->
                                                                <button class="btn btn-link btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $id_pemesanan; ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <!-- Button Delete -->
                                                                <button class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $id_pemesanan; ?>">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal Edit Pemesanan -->
                                                    <div class="modal fade" id="editModal<?= $id_pemesanan; ?>" tabindex="-1" aria-labelledby="editModalLabel<?= $id_pemesanan; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editModalLabel<?= $id_pemesanan; ?>">Edit Pemesanan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form method="post" action="">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_pemesanan" value="<?= $id_pemesanan; ?>">
                                                                        <div class="mb-3">
                                                                            <label for="jumlah_tiket" class="form-label">Jumlah Tiket</label>
                                                                            <input type="number" name="jumlah_tiket" class="form-control" value="<?= $jumlah_tiket; ?>" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="status_pemesanan" class="form-label">Status Pemesanan</label>
                                                                            <select name="status_pemesanan" class="form-control" required>
                                                                                <option value="Pending" <?= $status_pemesanan == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                                                <option value="Diterima" <?= $status_pemesanan == 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
                                                                                <option value="Batal" <?= $status_pemesanan == 'Batal' ? 'selected' : ''; ?>>Batal</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" name="editPemesanan" class="btn btn-primary">Simpan Perubahan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Delete Pemesanan -->
                                                    <div class="modal fade" id="deleteModal<?= $id_pemesanan; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $id_pemesanan; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteModalLabel<?= $id_pemesanan; ?>">Hapus Pemesanan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form method="post" action="">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_pemesanan" value="<?= $id_pemesanan; ?>">
                                                                        <p>Apakah Anda yakin ingin menghapus pemesanan ini?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" name="deletePemesanan" class="btn btn-danger">Hapus</button>
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