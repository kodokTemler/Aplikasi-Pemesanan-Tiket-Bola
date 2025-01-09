<?php
// Koneksi ke database
include '../controllers/koneksi.php';

session_start();

// Redirect jika pengguna belum login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID pemesanan dari URL
$id_pemesanan = isset($_GET['id_pemesanan']) ? $_GET['id_pemesanan'] : null;

if (!$id_pemesanan) {
    header("Location: index.php");
    exit();
}

// Ambil data pemesanan
$query = "SELECT tb_pemesanan.*, tb_event.nama_event FROM tb_pemesanan
          INNER JOIN tb_tiket ON tb_pemesanan.id_tiket = tb_tiket.id_tiket
          INNER JOIN tb_event ON tb_tiket.id_event = tb_event.id_event
          WHERE tb_pemesanan.id_pemesanan = '$id_pemesanan' AND tb_pemesanan.id_user = '$_SESSION[id_user]'";
$result = mysqli_query($koneksi, $query);
$pesanan = mysqli_fetch_assoc($result);

if (!$pesanan) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pemesanan = $_POST['id_pemesanan'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $status_pembayaran = 'Pending'; // Status awal pembayaran
    $tanggal_pembayaran = date('Y-m-d H:i:s');

    // Upload bukti pembayaran
    $bukti_pembayaran = $_FILES['bukti_pembayaran']['name'];
    $tmp_name = $_FILES['bukti_pembayaran']['tmp_name'];

    // Pastikan folder uploads/bukti/ ada dan memiliki izin yang tepat
    $upload_dir =  '../admin/uploads/bukti/'; // Menggunakan path absolut

    $upload_path = $upload_dir . basename($bukti_pembayaran);

    if (move_uploaded_file($tmp_name, $upload_path)) {
        // Simpan ke database
        $query = "INSERT INTO tb_pembayaran (id_pemesanan, metode_pembayaran, bukti_pembayaran, status_pembayaran, tanggal_pembayaran)
                  VALUES ('$id_pemesanan', '$metode_pembayaran', '$bukti_pembayaran', '$status_pembayaran', '$tanggal_pembayaran')";

        if (mysqli_query($koneksi, $query)) {

            echo "<script>alert('Pembayaran berhasil! Status Anda adalah Pending.'); window.location.href='index.php';</script>";
        } else {
            echo "Gagal memproses pembayaran.";
        }
    } else {
        echo "Gagal mengunggah bukti pembayaran.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <nav class="bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <!-- Logo -->
            <a href="#" class="text-white text-3xl font-extrabold tracking-wide">
                Tiket<span class="text-yellow-400">Bola</span>
            </a>

            <!-- Links -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="text-white font-medium hover:text-yellow-300 transition">Kembali</a>

                <!-- Tombol Logout -->
                <form action="logout.php" method="POST">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <section class="py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">Halaman Pembayaran</h1>

            <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Informasi Pemesanan</h2>

                <div class="mb-4">
                    <p class="text-lg font-medium text-gray-700">Event: <span class="font-bold"><?= $pesanan['nama_event']; ?></span></p>
                    <p class="text-lg font-medium text-gray-700">Jumlah Tiket: <span class="font-bold"><?= $pesanan['jumlah_tiket']; ?></span></p>
                    <p class="text-lg font-medium text-gray-700">Total Harga: <span class="font-bold">Rp<?= number_format($pesanan['total_harga'], 0, ',', '.'); ?></span></p>
                </div>

                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_pemesanan" value="<?= $id_pemesanan; ?>">

                    <div class="mb-4">
                        <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Pilih Metode Pembayaran</label>
                        <select name="metode_pembayaran" id="metode_pembayaran" class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" onchange="updateRekening()">
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="BNI">BNI</option>
                            <option value="BRI">BRI</option>
                            <option value="DANA">DANA</option>
                        </select>
                    </div>

                    <!-- Input nomor rekening tujuan (akan ditampilkan jika memilih Transfer Bank) -->
                    <div class="mb-4" id="rekening-container" style="display: none;">
                        <label for="no_rekening" class="block text-sm font-medium text-gray-700">Nomor Rekening Tujuan</label>
                        <input type="text" name="no_rekening" id="no_rekening" class="mt-2 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700">Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="mt-2 block w-full text-gray-700" required>
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                        <i class="fas fa-credit-card mr-2"></i> Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </section>

    <script>
        // Fungsi untuk mengupdate nomor rekening sesuai dengan metode pembayaran
        function updateRekening() {
            var metode = document.getElementById("metode_pembayaran").value;
            var rekeningInput = document.getElementById("no_rekening");
            var rekeningContainer = document.getElementById("rekening-container");

            // Cek jika metode pembayaran adalah BNI, BRI, atau DANA
            if (metode === "BNI" || metode === "BRI" || metode === "DANA") {
                rekeningContainer.style.display = "block"; // Tampilkan inputan nomor rekening
                // Set nomor rekening sesuai dengan pilihan
                switch (metode) {
                    case "BNI":
                        rekeningInput.value = "123-456-7890 (Ayub)";
                        break;
                    case "BRI":
                        rekeningInput.value = "987-654-3210 (Yozep)";
                        break;
                    case "DANA":
                        rekeningInput.value = "0812-3456-7890 (Ocep)";
                        break;
                    default:
                        rekeningInput.value = "Masukkan nomor rekening tujuan";
                        break;
                }
            } else {
                rekeningContainer.style.display = "none"; // Sembunyikan inputan jika bukan BNI, BRI, atau DANA
                rekeningInput.value = ""; // Kosongkan inputan jika tidak relevan
            }
        }
    </script>
</body>

</html>