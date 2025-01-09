<?php
// Koneksi ke database
include '../controllers/koneksi.php';

// Ambil ID tiket dari parameter URL
$id_tiket = isset($_GET['id_tiket']) ? $_GET['id_tiket'] : 0;

session_start();

// Redirect jika pengguna belum login
if (!isset($_SESSION['nama'])) {
    header("Location: login.php");
    exit();
}

// Ambil informasi pengguna dari session
$id_user = $_SESSION['id_user'];
$nama = $_SESSION['nama'];
$email = $_SESSION['email'];
$alamat = $_SESSION['alamat'];

// Ambil data tiket beserta informasi event dari database
$query = "
    SELECT 
        tb_tiket.id_tiket, tb_tiket.harga_tiket, tb_tiket.stok_tiket, 
        tb_event.nama_event, tb_event.gambar_event, tb_event.tanggal_event, tb_event.lokasi_event
    FROM 
        tb_tiket 
    INNER JOIN 
        tb_event 
    ON 
        tb_tiket.id_event = tb_event.id_event
    WHERE 
        tb_tiket.id_tiket = '$id_tiket'
";
$result = mysqli_query($koneksi, $query);

// Cek apakah data ditemukan
if ($result && mysqli_num_rows($result) > 0) {
    $tiket = mysqli_fetch_assoc($result);
    $harga_tiket = $tiket['harga_tiket'];
    $stok_tiket = $tiket['stok_tiket'];
    $nama_event = $tiket['nama_event'];
    $gambar_event = $tiket['gambar_event'];
    $tanggal_event = $tiket['tanggal_event'];
    $lokasi_event = $tiket['lokasi_event'];
} else {
    echo "<script>alert('Data tiket tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

// Proses pemesanan tiket
if (isset($_POST['pesan_tiket'])) {
    // Ambil data dari form
    // $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    // $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $jumlah_tiket = $_POST['jumlah_tiket'];
    $waktu_pesanan = $_POST['tanggal_pesanan'];

    // Hitung ulang total harga di backend
    $total_harga = $jumlah_tiket * $harga_tiket;

    if ($jumlah_tiket <= $stok_tiket) {
        // Insert data pemesanan dengan status "Pending"
        $insert_query = "
            INSERT INTO tb_pemesanan 
            (id_user, id_tiket, jumlah_tiket, total_harga, tanggal_pemesanan, status_pemesanan) 
            VALUES 
            ('$id_user', '$id_tiket', '$jumlah_tiket', '$total_harga', '$waktu_pesanan', 'Pending')
        ";

        if (mysqli_query($koneksi, $insert_query)) {
            // Update stok tiket
            $update_stok = "UPDATE tb_tiket SET stok_tiket = stok_tiket - '$jumlah_tiket' WHERE id_tiket = '$id_tiket'";
            mysqli_query($koneksi, $update_stok);

            echo "<script>alert('Pemesanan berhasil! Status Anda adalah Pending.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat pemesanan.'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Stok tiket tidak cukup.'); window.location.href='index.php';</script>";
    }
}


?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>

    <section id="order-ticket" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-blue-600">Form Pemesanan Tiket</h2>
            <div class="lg:flex items-center justify-between space-x-8">
                <!-- Kolom Kiri: Informasi Tiket -->
                <div class="w-full lg:w-1/2 bg-white p-6 rounded-lg shadow-lg">
                    <!-- Gambar Event -->
                    <img src="../admin/uploads/<?= $gambar_event; ?>" alt="<?= $nama_event; ?>" class="rounded-lg mb-4 w-full h-56 object-cover">
                    <!-- <h3 class="text-xl font-semibold text-blue-600 mb-2"><?= $nama_event; ?></h3> -->

                    <!-- Informasi Tiket -->
                    <h3 class="text-xl font-semibold text-blue-600 mb-2"><?= $nama_event; ?></h3>
                    <p class="text-gray-700 mb-2">
                        <i class="fas fa-ticket-alt text-purple-500 mr-2"></i>
                        <strong>Harga:</strong> Rp<?= number_format($harga_tiket, 0, ',', '.'); ?>
                    </p>
                    <p class="text-gray-700 mb-4">
                        <i class="fas fa-warehouse text-blue-500 mr-2"></i>
                        <strong>Stok:</strong> <?= $stok_tiket; ?>
                    </p>
                    <p class="text-gray-700 mb-4">
                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                        <strong>Tanggal:</strong> <?= date('d F Y', strtotime($tanggal_event)); ?>
                    </p>
                    <p class="text-gray-700 mb-4">
                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                        <strong>Lokasi:</strong> <?= $lokasi_event; ?>
                    </p>
                </div>


                <!-- Kolom Kanan: Form Pemesanan -->
                <div class="w-full lg:w-1/2 bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-2xl font-semibold text-blue-600 mb-4">Informasi Pemesanan</h3>
                    <form action="" method="POST">
                        <!-- Input Nama -->
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" class="w-full p-3 border rounded-lg" value="<?= $nama ?>" readonly>
                        </div>

                        <!-- Input Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" class="w-full p-3 border rounded-lg" value="<?= $_SESSION['email'] ?>" readonly>
                        </div>

                        <!-- Input Jumlah Tiket -->
                        <div class="mb-4">
                            <label for="jumlah_tiket" class="block text-gray-700 mb-2">Jumlah Tiket</label>
                            <input
                                type="number"
                                id="jumlah_tiket"
                                name="jumlah_tiket"
                                class="w-full p-3 border rounded-lg"
                                min="1"
                                max="<?= $stok_tiket; ?>"
                                required
                                oninput="updateTotalHarga()">
                        </div>

                        <!-- Input Total Harga -->
                        <div class="mb-4">
                            <label for="total_harga" class="block text-gray-700 mb-2">Total Harga</label>
                            <input
                                type="text"
                                id="total_harga"
                                name="total_harga"
                                class="w-full p-3 border rounded-lg"
                                value="Rp0"
                                readonly>
                        </div>

                        <!-- Pilihan Tanggal dan Waktu -->
                        <div class="mb-4">
                            <label for="tanggal_pesanan" class="block text-gray-700 mb-2">Tanggal & Waktu Pemesanan</label>
                            <input
                                type="datetime-local"
                                id="tanggal_pesanan"
                                name="tanggal_pesanan"
                                class="w-full p-3 border rounded-lg"
                                readonly>
                        </div>

                        <!-- Pilihan Alamat -->
                        <div class="mb-4">
                            <label for="alamat" class="block text-gray-700 mb-2">Alamat</label>
                            <textarea id="alamat" name="alamat" class="w-full p-3 border rounded-lg" readonly><?= $alamat ?></textarea>
                        </div>

                        <!-- Tombol Pesan Tiket -->
                        <div class="mb-4 col-span-2 flex justify-between space-x-4">
                            <!-- Tombol Pesan Tiket -->
                            <button type="submit" name="pesan_tiket"
                                class="w-1/2 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Pesan Tiket
                            </button>
                            <!-- Tombol Kembali -->
                            <a href="index.php"
                                class="w-1/2 py-3 bg-gray-600 text-white font-semibold rounded-lg text-center hover:bg-gray-700 transition">
                                Kembali
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Ambil elemen input tanggal dan waktu pesanan
        const tanggalPesananInput = document.getElementById("tanggal_pesanan");

        // Format tanggal dan waktu sekarang ke format YYYY-MM-DDTHH:MM
        const now = new Date();
        const yyyy = now.getFullYear();
        const mm = String(now.getMonth() + 1).padStart(2, '0'); // Bulan dari 0-11
        const dd = String(now.getDate()).padStart(2, '0');
        const hh = String(now.getHours()).padStart(2, '0');
        const min = String(now.getMinutes()).padStart(2, '0');

        const currentDateTime = `${yyyy}-${mm}-${dd}T${hh}:${min}`;

        // Atur nilai default input datetime-local
        tanggalPesananInput.value = currentDateTime;

        // Ambil elemen input jumlah tiket dan total harga
        const jumlahTiketInput = document.getElementById("jumlah_tiket");
        const totalHargaInput = document.getElementById("total_harga");

        // Harga tiket satuan
        const hargaTiket = <?= $harga_tiket; ?>;

        // Fungsi untuk memperbarui total harga
        function updateTotalHarga() {
            const jumlahTiket = parseInt(jumlahTiketInput.value) || 0;
            const totalHarga = jumlahTiket * hargaTiket;

            // Format harga ke format Rupiah
            totalHargaInput.value = `Rp${totalHarga.toLocaleString('id-ID')}`;
        }
    </script>

</body>

</html>