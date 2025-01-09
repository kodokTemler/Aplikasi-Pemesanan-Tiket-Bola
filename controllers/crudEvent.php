<?php
include 'koneksi.php';

// Fungsi untuk mengunggah gambar
function uploadImage($file, $folder = 'uploads/')
{
    $fileName = $file['name'];
    $fileTmp = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($fileExt, $allowedExt)) {
        return ['success' => false, 'message' => 'Format gambar tidak valid. Hanya JPG, JPEG, PNG, atau GIF yang diizinkan.'];
    }

    $newFileName = uniqid() . '.' . $fileExt;
    $destination = $folder . $newFileName;

    if (move_uploaded_file($fileTmp, $destination)) {
        return ['success' => true, 'fileName' => $newFileName];
    } else {
        return ['success' => false, 'message' => 'Gagal mengunggah gambar.'];
    }
}

// Tambah Event
if (isset($_POST['addEvent'])) {
    $nama_event = htmlspecialchars($_POST['nama_event']);
    $tanggal_event = $_POST['tanggal_event'];
    $waktu_event = $_POST['waktu_event'];
    $lokasi_event = htmlspecialchars($_POST['lokasi_event']);
    $deskripsi_event = htmlspecialchars($_POST['deskripsi_event']);
    $gambar_event = $_FILES['gambar_event'];

    // Upload gambar
    $uploadResult = uploadImage($gambar_event);
    if ($uploadResult['success']) {
        $gambarName = $uploadResult['fileName'];

        $sql = "INSERT INTO tb_event (nama_event, tanggal_event, waktu_event, lokasi_event, deskripsi_event, gambar_event) 
                VALUES ('$nama_event', '$tanggal_event', '$waktu_event', '$lokasi_event', '$deskripsi_event', '$gambarName')";
        if (mysqli_query($koneksi, $sql)) {
            header("Location: daftarEvent.php?active=daftarEvent");
        } else {
            header("Location: daftarEvent.php?active=daftarEvent");
        }
    } else {
        header("Location: daftarEvent.php?active=daftarEvent" . $uploadResult['message']);
    }
}

// Edit Event
if (isset($_POST['editEvent'])) {
    $id_event = $_POST['id_event'];
    $nama_event = htmlspecialchars($_POST['nama_event']);
    $tanggal_event = $_POST['tanggal_event'];
    $waktu_event = $_POST['waktu_event'];
    $lokasi_event = htmlspecialchars($_POST['lokasi_event']);
    $deskripsi_event = htmlspecialchars($_POST['deskripsi_event']);
    $gambar_event = $_FILES['gambar_event'];

    $updateQuery = "UPDATE tb_event SET 
                    nama_event = '$nama_event', 
                    tanggal_event = '$tanggal_event', 
                    waktu_event = '$waktu_event', 
                    lokasi_event = '$lokasi_event', 
                    deskripsi_event = '$deskripsi_event'";

    // Jika ada file gambar yang diunggah
    if ($gambar_event['error'] == 0) {
        // Upload gambar baru
        $uploadResult = uploadImage($gambar_event);
        if ($uploadResult['success']) {
            $gambarName = $uploadResult['fileName'];
            $updateQuery .= ", gambar_event = '$gambarName'";
        } else {
            header("Location: daftarEvent.php?active=daftarEvent" . $uploadResult['message']);
            exit();
        }
    }

    $updateQuery .= " WHERE id_event = '$id_event'";
    if (mysqli_query($koneksi, $updateQuery)) {
        header("Location: daftarEvent.php?active=daftarEvent");
    } else {
        header("Location: daftarEvent.php?active=daftarEvent");
    }
}

// Hapus Event
if (isset($_POST['deleteEvent'])) {
    $id_event = $_POST['id_event'];

    // Hapus file gambar terlebih dahulu
    $queryGambar = "SELECT gambar_event FROM tb_event WHERE id_event = '$id_event'";
    $resultGambar = mysqli_query($koneksi, $queryGambar);
    if ($resultGambar && mysqli_num_rows($resultGambar) > 0) {
        $dataGambar = mysqli_fetch_assoc($resultGambar);
        $gambarPath = 'uploads/' . $dataGambar['gambar_event'];
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }
    }

    // Hapus data event
    $deleteQuery = "DELETE FROM tb_event WHERE id_event = '$id_event'";
    if (mysqli_query($koneksi, $deleteQuery)) {
        header("Location: daftarEvent.php?active=daftarEvent");
    } else {
        header("Location: daftarEvent.php?active=daftarEvent");
    }
}
