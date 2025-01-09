<?php
// Koneksi ke database
include '../controllers/koneksi.php';

session_start();

// Redirect jika pengguna belum login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID pembayaran dari URL
$id_pembayaran = $_GET['id_pembayaran'];

// Ambil data pemesanan dan pembayaran berdasarkan ID pembayaran
$query = "
    SELECT 
        tb_pemesanan.id_pemesanan, tb_pemesanan.jumlah_tiket, tb_pemesanan.total_harga, 
        tb_pemesanan.status_pemesanan, tb_pemesanan.tanggal_pemesanan, 
        tb_event.nama_event, tb_event.tanggal_event, tb_event.lokasi_event, tb_event.gambar_event, tb_tiket.kategori_tiket,
        tb_pembayaran.status_pembayaran, tb_pembayaran.tanggal_pembayaran,
        tb_user.nama, tb_user.email
    FROM 
        tb_pembayaran
    INNER JOIN 
        tb_pemesanan ON tb_pembayaran.id_pemesanan = tb_pemesanan.id_pemesanan
    INNER JOIN 
        tb_tiket ON tb_pemesanan.id_tiket = tb_tiket.id_tiket
    INNER JOIN 
        tb_event ON tb_tiket.id_event = tb_event.id_event
    INNER JOIN
        tb_user ON tb_pemesanan.id_user = tb_user.id_user
    WHERE 
        tb_pembayaran.id_pembayaran = '$id_pembayaran'
";

$result = mysqli_query($koneksi, $query);
$pesanan = mysqli_fetch_assoc($result);

// Pastikan data ditemukan
if (!$pesanan) {
    echo "Data tidak ditemukan.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Tiket Sepak Bola</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
        }

        .ticket {
            width: 600px;
            margin: 50px auto;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .ticket-header img {
            width: 100px;
            height: auto;
        }

        .ticket-header h1 {
            font-size: 24px;
            color: #2b6cb0;
            margin: 10px 0;
        }

        .ticket-details {
            margin-bottom: 20px;
        }

        .ticket-details p {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .ticket-details .highlight {
            font-weight: bold;
            color: #2b6cb0;
        }

        .ticket-footer {
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .barcode {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="ticket">
        <div class="ticket-header">
            <img src="../admin/uploads/<?= $pesanan['gambar_event']; ?>" alt="Logo Event">
            <h1>Tiket Sepak Bola</h1>
            <p>Acara: <?= $pesanan['nama_event']; ?></p>
        </div>

        <div class="ticket-details">
            <p><span class="highlight">Nama Pemesan:</span> <?= $pesanan['nama']; ?></p>
            <p><span class="highlight">Email Pemesan:</span> <?= $pesanan['email']; ?></p>
            <p><span class="highlight">Kategori Acara:</span> <?= $pesanan['kategori_tiket']; ?></p>
            <p><span class="highlight">Tanggal Event:</span> <?= date('d F Y', strtotime($pesanan['tanggal_event'])); ?></p>
            <p><span class="highlight">Stadion:</span> <?= $pesanan['lokasi_event']; ?></p>
            <p><span class="highlight">Jumlah Tiket:</span> <?= $pesanan['jumlah_tiket']; ?> Tiket</p>
            <p><span class="highlight">Total Harga:</span> Rp<?= number_format($pesanan['total_harga'], 0, ',', '.'); ?></p>
            <p><span class="highlight">Tanggal Pemesanan:</span> <?= date('d F Y H:i', strtotime($pesanan['tanggal_pemesanan'])); ?></p>
        </div>

        <div class="ticket-footer">
            <p>Status Pembayaran: <span class="highlight"><?= $pesanan['status_pembayaran']; ?></span></p>
            <p>Nomor Pemesanan: <?= $pesanan['id_pemesanan']; ?></p>
            <p>Nomor Tiket: <?= "TKT" . str_pad($pesanan['id_pemesanan'], 6, "0", STR_PAD_LEFT); ?></p>
        </div>

        <div class="barcode">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= $pesanan['id_pemesanan']; ?>&size=150x150" alt="QR Code Tiket">
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>