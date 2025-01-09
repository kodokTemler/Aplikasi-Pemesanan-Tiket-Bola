<?php
include 'koneksi.php'; // File koneksi ke database

if (isset($_POST['daftarUser'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $confirm_password = $_POST['confirm_password'];
    $no_hp = htmlspecialchars($_POST['no_telp']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $role = 'user'; // Set default role sebagai "user"

    // Validasi konfirmasi password
    if (!password_verify($confirm_password, $password)) {
        echo "<script>
                alert('Konfirmasi password tidak sesuai!');
                window.location.href = 'index.php';
              </script>";
        exit;
    }

    // Cek apakah email sudah digunakan
    $query = "SELECT * FROM tb_user WHERE email = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Email sudah terdaftar!');
                window.location.href = 'index.php';
              </script>";
        exit;
    }

    // Insert data ke database
    $query = "INSERT INTO tb_user (nama, email, password, no_hp, alamat, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ssssss", $nama, $email, $password, $no_hp, $alamat, $role);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Registrasi gagal! Silakan coba lagi.');
                window.location.href = 'index.php';
              </script>";
    }
}

session_start();

if (isset($_POST['masukUser'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // Ambil role dari form login

    // Cek apakah user ada di database
    $query = "SELECT * FROM tb_user WHERE email = ? AND role = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['no_hp'] = $user['no_hp'];
            $_SESSION['alamat'] = $user['alamat'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan role
            if ($role === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: user/index.php");
            }
            exit;
        } else {
            echo "<script>
                    alert('Password salah!');
                    window.location.href = 'index.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Email atau role tidak ditemukan!');
                window.location.href = 'index.php';
              </script>";
    }
}
