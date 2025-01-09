<?php
// Koneksi ke database
include 'koneksi.php';

// CREATE - Tambah Tiket
if (isset($_POST['addTiket'])) {
    $id_event = $_POST['id_event'];
    $kategori_tiket = $_POST['kategori_tiket'];
    $harga_tiket = $_POST['harga_tiket'];
    $stok_tiket = $_POST['stok_tiket'];

    $sql = "INSERT INTO tb_tiket (id_event, kategori_tiket, harga_tiket, stok_tiket) VALUES ('$id_event', '$kategori_tiket', '$harga_tiket', '$stok_tiket')";
    if (mysqli_query($koneksi, $sql)) {
        // Redirect setelah berhasil menambah tiket
        header('Location: daftarTiket.php?active=daftarTiket');
    } else {
        // Jika gagal menambah tiket
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// UPDATE - Edit Tiket
if (isset($_POST['editTiket'])) {
    $id_tiket = $_POST['id_tiket'];
    $id_event = $_POST['id_event'];
    $kategori_tiket = $_POST['kategori_tiket'];
    $harga_tiket = $_POST['harga_tiket'];
    $stok_tiket = $_POST['stok_tiket'];

    $sql = "UPDATE tb_tiket SET id_event = '$id_event', kategori_tiket = '$kategori_tiket', harga_tiket = '$harga_tiket', stok_tiket = '$stok_tiket' WHERE id_tiket = '$id_tiket'";
    if (mysqli_query($koneksi, $sql)) {
        // Redirect setelah berhasil mengedit tiket
        header('Location: daftarTiket.php?active=daftarTiket');
    } else {
        // Jika gagal mengedit tiket
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}

// DELETE - Hapus Tiket
if (isset($_POST['deleteTiket'])) {
    $id_tiket = $_POST['id_tiket'];

    $sql = "DELETE FROM tb_tiket WHERE id_tiket = '$id_tiket'";
    if (mysqli_query($koneksi, $sql)) {
        // Redirect setelah berhasil menghapus tiket
        header('Location: daftarTiket.php?active=daftarTiket');
    } else {
        // Jika gagal menghapus tiket
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
    }
}
