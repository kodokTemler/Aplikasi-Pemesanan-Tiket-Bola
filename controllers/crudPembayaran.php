<?php
include '../controllers/koneksi.php';

if (isset($_POST['edit_pembayaran'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $status_pembayaran = $_POST['status_pembayaran'];

    // Update data pembayaran
    $updateSql = "UPDATE tb_pembayaran 
                  SET metode_pembayaran = '$metode_pembayaran', status_pembayaran = '$status_pembayaran'
                  WHERE id_pembayaran = '$id_pembayaran'";
    if (mysqli_query($koneksi, $updateSql)) {
        header("Location: daftarPembayaran.php?active=daftarPembayaran");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

if (isset($_POST['hapus_pembayaran'])) {
    $id_pembayaran = $_POST['id_pembayaran'];

    // Mengambil bukti pembayaran dari database
    $selectSql = "SELECT bukti_pembayaran FROM tb_pembayaran WHERE id_pembayaran = '$id_pembayaran'";
    $result = mysqli_query($koneksi, $selectSql);
    $row = mysqli_fetch_assoc($result);
    $bukti_pembayaran = $row['bukti_pembayaran'];

    // Hapus file bukti pembayaran jika ada
    if ($bukti_pembayaran != null) {
        $filePath = "../uploads/bukti/" . $bukti_pembayaran;
        if (file_exists($filePath)) {
            unlink($filePath);  // Menghapus file bukti pembayaran
        }
    }

    // Hapus data pembayaran dari database
    $deleteSql = "DELETE FROM tb_pembayaran WHERE id_pembayaran = '$id_pembayaran'";
    if (mysqli_query($koneksi, $deleteSql)) {
        header("Location: daftarPembayaran.php?active=daftarPembayaran");  // Redirect kembali ke halaman pembayaran setelah penghapusan
        exit;
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
