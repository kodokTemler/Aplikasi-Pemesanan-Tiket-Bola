<?php
include 'koneksi.php';

// Edit Data User
if (isset($_POST['editDataUser'])) {
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_telp'];
    $alamat = $_POST['alamat'];
    $role = $_POST['role'];

    $updateSql = "UPDATE tb_user SET nama = '$nama', email = '$email', no_hp = '$no_hp', alamat = '$alamat', role = '$role' WHERE id_user = $id_user";
    mysqli_query($koneksi, $updateSql);
}

// Hapus Data User
if (isset($_POST['deleteDataUser'])) {
    $id_user = $_POST['id_user'];

    $deleteSql = "DELETE FROM tb_user WHERE id_user = $id_user";
    mysqli_query($koneksi, $deleteSql);
}
