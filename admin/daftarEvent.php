<?php
include '../controllers/crudEvent.php';
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
                        <h3 class="fw-bold mb-3">Event Management</h3>
                        <ul class="breadcrumbs mb-3">
                            <li class="nav-home">
                                <a href="index.php"><i class="icon-home"></i></a>
                            </li>
                            <li class="separator"><i class="icon-arrow-right"></i></li>
                            <li class="nav-item"><a href="event.php">Event</a></li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div class="card-title">Event Table</div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                                        <i class="fa fa-plus"></i> Add Event
                                    </button>
                                </div>

                                <!-- Modal Tambah Event -->
                                <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
                                    <div class="modal-dialog"> <!-- Ubah modal menjadi lebih besar -->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addEventModalLabel">Tambah Event</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post" action="" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="row"> <!-- Tambahkan gap antar elemen -->
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="nama_event" class="form-label">Nama Event</label>
                                                                    <input type="text" name="nama_event" id="nama_event" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="tanggal_event" class="form-label">Tanggal Event</label>
                                                                    <input type="date" name="tanggal_event" id="tanggal_event" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="waktu_event" class="form-label">Waktu Event</label>
                                                                    <input type="time" name="waktu_event" id="waktu_event" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="lokasi_event" class="form-label">Lokasi Event</label>
                                                                    <input type="text" name="lokasi_event" id="lokasi_event" class="form-control" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label for="deskripsi_event" class="form-label">Deskripsi Event</label>
                                                                    <textarea name="deskripsi_event" id="deskripsi_event" class="form-control" rows="3" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="mb-3">
                                                                    <label for="gambar_event" class="form-label">Gambar Event</label>
                                                                    <input type="file" name="gambar_event" id="gambar_event" class="form-control" accept="image/*" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" name="addEvent" class="btn btn-primary">Tambah Event</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="basic-datatables" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Event</th>
                                                    <th scope="col">Tanggal</th>
                                                    <th scope="col">Waktu</th>
                                                    <th scope="col">Lokasi</th>
                                                    <th scope="col">Deskripsi</th>
                                                    <th scope="col">Gambar</th>
                                                    <th scope="col" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $eventSql = "SELECT * FROM tb_event";
                                                $eventRes = mysqli_query($koneksi, $eventSql);
                                                $eventCount = 1;

                                                while ($event = mysqli_fetch_assoc($eventRes)) {
                                                    $id_event = $event['id_event'];
                                                    $nama_event = $event['nama_event'];
                                                    $tanggal_event = $event['tanggal_event'];
                                                    $waktu_event = $event['waktu_event'];
                                                    $lokasi_event = $event['lokasi_event'];
                                                    $deskripsi_event = $event['deskripsi_event'];
                                                    $gambar_event = $event['gambar_event'];
                                                ?>
                                                    <tr>
                                                        <td><?= $eventCount++ ?></td>
                                                        <td><?= $nama_event ?></td>
                                                        <td><?= $tanggal_event ?></td>
                                                        <td><?= $waktu_event ?></td>
                                                        <td><?= $lokasi_event ?></td>
                                                        <td><?= $deskripsi_event ?></td>
                                                        <td>
                                                            <img src="uploads/<?= $gambar_event ?>" alt="Gambar Event" width="100">
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <button class="btn btn-link btn-primary" data-bs-toggle="modal" data-bs-target="#editEventModal<?= $id_event; ?>">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                                <button class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#deleteEventModal<?= $id_event; ?>">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Edit Modal & Delete Modal -->
                                                    <!-- Modal Edit Event -->
                                                    <div class="modal fade" id="editEventModal<?= $id_event; ?>" tabindex="-1" aria-labelledby="editEventModalLabel<?= $id_event; ?>" aria-hidden="true">
                                                        <div class="modal-dialog"> <!-- Modal lebih besar -->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editEventModalLabel<?= $id_event; ?>">Edit Event</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form method="post" action="" enctype="multipart/form-data">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_event" value="<?= $id_event; ?>">
                                                                        <div class="container-fluid">
                                                                            <div class="row g-3"> <!-- Tambahkan jarak antar elemen -->
                                                                                <div class="col-md-6">
                                                                                    <div class="mb-3">
                                                                                        <label for="edit_nama_event<?= $id_event; ?>" class="form-label">Nama Event</label>
                                                                                        <input type="text" name="nama_event" id="edit_nama_event<?= $id_event; ?>" class="form-control" value="<?= $nama_event; ?>" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="mb-3">
                                                                                        <label for="edit_tanggal_event<?= $id_event; ?>" class="form-label">Tanggal Event</label>
                                                                                        <input type="date" name="tanggal_event" id="edit_tanggal_event<?= $id_event; ?>" class="form-control" value="<?= $tanggal_event; ?>" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="mb-3">
                                                                                        <label for="edit_waktu_event<?= $id_event; ?>" class="form-label">Waktu Event</label>
                                                                                        <input type="time" name="waktu_event" id="edit_waktu_event<?= $id_event; ?>" class="form-control" value="<?= $waktu_event; ?>" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="mb-3">
                                                                                        <label for="edit_lokasi_event<?= $id_event; ?>" class="form-label">Lokasi Event</label>
                                                                                        <input type="text" name="lokasi_event" id="edit_lokasi_event<?= $id_event; ?>" class="form-control" value="<?= $lokasi_event; ?>" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="mb-3">
                                                                                        <label for="edit_deskripsi_event<?= $id_event; ?>" class="form-label">Deskripsi Event</label>
                                                                                        <textarea name="deskripsi_event" id="edit_deskripsi_event<?= $id_event; ?>" class="form-control" rows="3" required><?= $deskripsi_event; ?></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="mb-3">
                                                                                        <label for="edit_gambar_event<?= $id_event; ?>" class="form-label">Gambar Event</label>
                                                                                        <input type="file" name="gambar_event" id="edit_gambar_event<?= $id_event; ?>" class="form-control" accept="image/*">
                                                                                        <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" name="editEvent" class="btn btn-primary">Simpan Perubahan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Tambahkan logika seperti sebelumnya -->
                                                    <!-- Modal Delete Event -->
                                                    <div class="modal fade" id="deleteEventModal<?= $id_event; ?>" tabindex="-1" aria-labelledby="deleteEventModalLabel<?= $id_event; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="deleteEventModalLabel<?= $id_event; ?>">Hapus Event</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <form method="post" action="">
                                                                    <div class="modal-body">
                                                                        <input type="hidden" name="id_event" value="<?= $id_event; ?>">
                                                                        <p>Apakah Anda yakin ingin menghapus event <strong><?= $nama_event; ?></strong>?</p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit" name="deleteEvent" class="btn btn-danger">Hapus</button>
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