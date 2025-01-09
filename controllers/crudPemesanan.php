<?php
// Koneksi database
include 'koneksi.php';

// Edit Pemesanan
if (isset($_POST['editPemesanan'])) {
    $id_pemesanan = $_POST['id_pemesanan'];
    $jumlah_tiket = $_POST['jumlah_tiket'];
    $status_pemesanan = $_POST['status_pemesanan'];

    // Update query
    $updateSql = "UPDATE tb_pemesanan SET jumlah_tiket = '$jumlah_tiket', status_pemesanan = '$status_pemesanan' WHERE id_pemesanan = '$id_pemesanan'";
    if (mysqli_query($koneksi, $updateSql)) {
        header("Location: daftarPemesanan.php?active=daftarPemesanan");
    } else {
        header("Location: daftarPemesanan.php?active=daftarPemesanan");
    }
}

// Hapus Pemesanan
if (isset($_POST['deletePemesanan'])) {
    $id_pemesanan = $_POST['id_pemesanan'];

    // Delete query
    $deleteSql = "DELETE FROM tb_pemesanan WHERE id_pemesanan = '$id_pemesanan'";
    if (mysqli_query($koneksi, $deleteSql)) {
        header("Location: daftarPemesanan.php?active=daftarPemesanan");
    } else {
        header("Location: daftarPemesanan.php?active=daftarPemesanan");
    }
}
