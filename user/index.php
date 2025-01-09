<?php
include '../controllers/koneksi.php';

session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Tiket Bola</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        fadeIn: 'fadeIn 2s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': {
                                opacity: 0
                            },
                            '100%': {
                                opacity: 1
                            },
                        },
                    },
                },
            },
        }
    </script>
</head>

<body class="font-sans bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center px-6 py-3">
            <!-- Logo -->
            <a href="#" class="text-white text-3xl font-extrabold tracking-wide">
                Tiket<span class="text-yellow-400">Bola</span>
            </a>

            <!-- Links -->
            <div class="hidden md:flex justify-center flex-grow">
                <ul class="flex space-x-8">
                    <li>
                        <a href="#home" class="text-white font-medium hover:text-yellow-300 transition">Home</a>
                    </li>
                    <li>
                        <a href="#about" class="text-white font-medium hover:text-yellow-300 transition">About Me</a>
                    </li>
                    <li>
                        <a href="#matches" class="text-white font-medium hover:text-yellow-300 transition">Daftar Pertandingan</a>
                    </li>
                    <li>
                        <a href="#contact" class="text-white font-medium hover:text-yellow-300 transition">Contact Us</a>
                    </li>
                </ul>
            </div>

            <div class="hidden md:flex space-x-4">
                <a href="hasilPemesanan.php" class="font-semibold text-white bg-green-600 hover:bg-green-700 transition duration-300 px-4 py-2 rounded">Hasil Pemesanan</a>

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
            <a href="#home" class="text-white font-medium hover:text-yellow-300 transition">Home</a>
            <a href="#about" class="text-white font-medium hover:text-yellow-300 transition">About Me</a>
            <a href="#matches" class="text-white font-medium hover:text-yellow-300 transition">Daftar Pertandingan</a>
            <a href="#contact" class="text-white font-medium hover:text-yellow-300 transition">Contact Us</a>
            <a href="hasilPemesanan.php" class="text-white font-medium hover:text-yellow-300 transition">Hasil Pemesanan</a>
            <form action="logout.php" method="POST">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition">
                    Logout
                </button>
            </form>
        </div>
    </nav>



    <!-- Header -->
    <header id="home" class="bg-cover bg-center h-screen" style="background-image: url('../admin/assets/img/bg.jpg');">
        <div class="h-full bg-opacity-60 bg-black flex items-center justify-center">
            <div class="text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fadeIn">Pesan Tiket Pertandingan Bola</h1>
                <p class="text-lg md:text-2xl mb-6 animate-fadeIn">Nikmati pengalaman nonton bola yang seru!</p>
                <a href="#matches" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">Pesan Sekarang <?= $_SESSION['nama'] ?></a>
            </div>
        </div>
    </header>

    <!-- About Me -->
    <section id="about" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-blue-600">About Us</h2>
            <div class="md:flex md:space-x-8">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <img src="../admin/assets/img/about.jpg" alt="Soccer" class="rounded-lg shadow-lg">
                </div>
                <div class="md:w-1/2 space-y-4">
                    <p class="text-gray-700 text-lg">Kami adalah penyedia tiket resmi untuk pertandingan sepak bola terbaik di Indonesia. Kami memberikan kemudahan dalam memesan tiket dan menyediakan informasi lengkap mengenai pertandingan.</p>
                    <p class="text-gray-700 text-lg">Jadilah bagian dari pengalaman nonton langsung di stadion dengan sistem pemesanan kami yang cepat dan terpercaya.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Daftar Pertandingan -->
    <section id="matches" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-blue-600">Daftar Tiket Pertandingan</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php
                // Query untuk mengambil data dari tb_event dan tb_tiket dengan join
                $query = "
                SELECT e.nama_event, e.tanggal_event, e.lokasi_event, e.waktu_event, e.gambar_event, 
                       t.id_tiket, t.kategori_tiket, t.harga_tiket, t.stok_tiket
                FROM tb_event e
                INNER JOIN tb_tiket t ON e.id_event = t.id_event
            ";
                $result = mysqli_query($koneksi, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Data dari tabel event dan tiket
                        $nama_event = $row['nama_event'];
                        $tanggal_event = $row['tanggal_event'];
                        $lokasi_event = $row['lokasi_event'];
                        $waktu_event = $row['waktu_event'];
                        $gambar_event = $row['gambar_event']; // URL gambar event
                        $kategori_tiket = $row['kategori_tiket'];
                        $harga_tiket = $row['harga_tiket'];
                        $stok_tiket = $row['stok_tiket'];
                ?>
                        <!-- Card Pertandingan -->
                        <div class="bg-white p-6 rounded-md shadow-md hover:shadow-2xl transform hover:scale-105 transition duration-300">
                            <!-- Gambar Event -->
                            <img src="../admin/uploads/<?= $gambar_event; ?>" alt="<?= $nama_event; ?>" class="rounded-lg mb-4 w-full object-cover h-56">

                            <!-- Nama Event -->
                            <h3 class="text-2xl font-bold mb-4 text-blue-600 text-center"><?= $nama_event; ?></h3>

                            <!-- Informasi Event & Tiket -->
                            <div class="flex flex-col md:flex-row justify-between space-y-4 md:space-y-0">
                                <!-- Kolom Kiri: Informasi Event -->
                                <div class="flex flex-col space-y-2 w-full md:w-1/2">
                                    <p class="flex items-center text-gray-700">
                                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                                        <?= date('d F Y', strtotime($tanggal_event)); ?>
                                    </p>
                                    <p class="flex items-center text-gray-700">
                                        <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                        <?= $lokasi_event; ?>
                                    </p>
                                    <p class="flex items-center text-gray-700">
                                        <i class="fas fa-clock text-green-500 mr-2"></i>
                                        <?= date('H:i:s', strtotime($waktu_event)); ?>
                                    </p>
                                </div>

                                <!-- Kolom Kanan: Informasi Tiket -->
                                <div class="flex flex-col space-y-2 w-full md:w-1/2">
                                    <p class="flex items-center text-gray-700">
                                        <i class="fas fa-ticket-alt text-purple-500 mr-2"></i>
                                        <strong>Kategori:</strong> <?= $kategori_tiket; ?>
                                    </p>
                                    <p class="flex items-center text-gray-700">
                                        <i class="fas fa-money-bill-wave text-yellow-500 mr-2"></i>
                                        <strong>Harga:</strong> Rp<?= number_format($harga_tiket, 0, ',', '.'); ?>
                                    </p>
                                    <p class="flex items-center text-gray-700">
                                        <i class="fas fa-warehouse text-blue-500 mr-2"></i>
                                        <strong>Stok:</strong> <?= $stok_tiket; ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Tombol Pesan atau Status -->
                            <div class="mt-6 flex justify-center">
                                <?php if ($stok_tiket > 0) { ?>
                                    <a href="pesan.php?id_tiket=<?= $row['id_tiket']; ?>" class="bg-blue-600 text-white py-2 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300 flex items-center">
                                        <i class="fas fa-shopping-cart mr-2"></i> Pesan Tiket
                                    </a>
                                <?php } else { ?>
                                    <a href="" class="bg-red-600 text-white py-2 px-6 rounded-lg font-semibold hover:bg-red-700 transition duration-300 flex items-center">
                                        <i class="fas fa-times-circle mr-2"></i> Tiket Habis
                                    </a>
                                <?php } ?>
                            </div>
                        </div>

                <?php
                    }
                } else {
                    echo "<p class='text-gray-700 text-center col-span-3'>Tidak ada tiket yang tersedia saat ini.</p>";
                }
                ?>
            </div>
        </div>
    </section>


    <!-- Contact Us -->
    <section id="contact" class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8 text-blue-600">Contact Us</h2>
            <form action="#" class="max-w-2xl mx-auto space-y-4">
                <input type="text" placeholder="Nama Anda" class="w-full p-3 rounded-lg border border-gray-300">
                <input type="email" placeholder="Email Anda" class="w-full p-3 rounded-lg border border-gray-300">
                <textarea placeholder="Pesan Anda" class="w-full p-3 rounded-lg border border-gray-300"></textarea>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">Kirim Pesan</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-blue-600 text-white py-6">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Tiket Bola. All Rights Reserved.</p>
        </div>
    </footer>


    <script>
        const mobileMenuBtn = document.getElementById("mobile-menu-btn");
        const mobileMenu = document.getElementById("mobile-menu");

        mobileMenuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    </script>

</body>

</html>