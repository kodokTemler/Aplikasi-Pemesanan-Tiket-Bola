<?php
// Koneksi ke database
include '../controllers/koneksi.php';

session_start();

// Redirect jika pengguna belum login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID user dari session
$id_user = $_SESSION['id_user'];

// Ambil data pemesanan user dari database
$query = "
    SELECT 
        tb_pemesanan.id_pemesanan, tb_pemesanan.jumlah_tiket, tb_pemesanan.total_harga, 
        tb_pemesanan.status_pemesanan, tb_pemesanan.tanggal_pemesanan, 
        tb_event.nama_event, tb_event.gambar_event,
        tb_pembayaran.status_pembayaran, tb_pembayaran.id_pembayaran
    FROM 
        tb_pemesanan
    INNER JOIN 
        tb_tiket ON tb_pemesanan.id_tiket = tb_tiket.id_tiket
    INNER JOIN 
        tb_event ON tb_tiket.id_event = tb_event.id_event
    LEFT JOIN 
        tb_pembayaran ON tb_pemesanan.id_pemesanan = tb_pembayaran.id_pemesanan
    WHERE 
        tb_pemesanan.id_user = '$id_user'
    ORDER BY 
        tb_pemesanan.tanggal_pemesanan DESC
";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pesanan Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
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

            <!-- Mobile Menu Button -->
            <button class="md:hidden text-white" id="mobile-menu-btn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div class="hidden bg-blue-500 md:hidden flex flex-col space-y-4 py-4 px-6" id="mobile-menu">
            <a href="index.php" class="text-white font-medium hover:text-yellow-300 transition">Kembali</a>
            <form action="logout.php" method="POST">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <section class="py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-3xl font-bold text-center text-blue-600 mb-8">Hasil Pesanan Saya</h1>

            <?php if (mysqli_num_rows($result) > 0) { ?>
                <div class="overflow-x-auto">
                    <table class="table-auto w-full border-collapse bg-white shadow-md rounded-lg">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left">Gambar</th>
                                <th class="px-6 py-3 text-left">Nama Event</th>
                                <th class="px-6 py-3 text-left">Jumlah Tiket</th>
                                <th class="px-6 py-3 text-left">Total Harga</th>
                                <th class="px-6 py-3 text-left">Status Pemesanan</th>
                                <th class="px-6 py-3 text-left">Status Pembayaran</th>
                                <th class="px-6 py-3 text-left">Tanggal Pesanan</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($pesanan = mysqli_fetch_assoc($result)) { ?>
                                <tr class="border-b hover:bg-gray-100 transition">
                                    <td class="px-6 py-4">
                                        <img src="../admin/uploads/<?= $pesanan['gambar_event']; ?>" alt="<?= $pesanan['nama_event']; ?>" class="rounded-lg w-16 h-16 object-cover">
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 font-semibold"><?= $pesanan['nama_event']; ?></td>
                                    <td class="px-6 py-4 text-gray-700"><?= $pesanan['jumlah_tiket']; ?></td>
                                    <td class="px-6 py-4 text-gray-700">Rp<?= number_format($pesanan['total_harga'], 0, ',', '.'); ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-sm font-semibold rounded-lg <?= $pesanan['status_pemesanan'] === 'Batal' ? 'bg-red-100 text-red-600' : ($pesanan['status_pemesanan'] === 'Diterima' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'); ?>">
                                            <?= $pesanan['status_pemesanan']; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-sm font-semibold rounded-lg <?= $pesanan['status_pembayaran'] === 'Dibatalkan' ? 'bg-red-100 text-red-600' : ($pesanan['status_pembayaran'] === 'Sukses' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600'); ?>">
                                            <?= $pesanan['status_pembayaran']; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700"><?= date('d F Y H:i', strtotime($pesanan['tanggal_pemesanan'])); ?></td>
                                    <td class="px-6 py-4 text-center">
                                        <?php
                                        // Logika untuk Aksi
                                        if ($pesanan['status_pemesanan'] === 'Diterima') {
                                            if ($pesanan['status_pembayaran'] === 'Sukses') {
                                                echo '<a href="cetak_tiket.php?id_pembayaran=' . $pesanan['id_pembayaran'] . '" class="text-green-600 font-semibold hover:underline" target="_blank">Cetak Tiket</a>';
                                            } elseif ($pesanan['status_pembayaran'] === 'Pending') {
                                                echo 'Tidak Ada Tiket';
                                            } elseif ($pesanan['status_pembayaran'] === 'Dibatalkan') {
                                                echo '<a href="bayar.php?id_pemesanan=' . $pesanan['id_pemesanan'] . '" class="text-blue-600 font-semibold hover:underline">Bayar</a>';
                                            } elseif ($pesanan['status_pemesanan'] === 'Diterima') {
                                                echo '<a href="bayar.php?id_pemesanan=' . $pesanan['id_pemesanan'] . '" class="text-blue-600 font-semibold hover:underline">Bayar</a>';
                                            }
                                        } elseif ($pesanan['status_pemesanan'] === 'Pending') {
                                            echo '<a href="hasilPemesanan.php" class="text-yellow-600 font-semibold hover:underline">Mohon Menunggu</a>';
                                        } elseif ($pesanan['status_pemesanan'] === 'Batal') {
                                            echo '<a href="hasilPemesanan.php" class="text-red-600 font-semibold hover:underline">Pesanan Dibatalakan</a>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <p class="text-center text-gray-700 text-xl">Belum ada pesanan yang dilakukan.</p>
            <?php } ?>
        </div>
    </section>

</body>

</html>