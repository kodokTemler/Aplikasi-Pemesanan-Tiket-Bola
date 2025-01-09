<?php
include 'controllers/login.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
        }

        .input-wrapper {
            position: relative;
        }

        .input-field {
            padding-left: 40px;
        }

        .form-transition {
            transition: opacity 0.4s ease-in-out, transform 0.4s ease-in-out;
            opacity: 0;
            transform: translateY(10px);
            display: none;
        }

        .form-transition-active {
            opacity: 1;
            transform: translateY(0);
            display: block;
        }

        body,
        .bg-form {
            background-image: url("admin/assets/img/bg.jpg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            background-attachment: fixed;
        }
    </style>
    <title>Login</title>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-form p-8 rounded-lg shadow-lg w-96">
        <h2 id="form-title" class="text-2xl font-bold text-center mb-6">Login</h2>
        <form id="form" action="#" method="POST" onsubmit="handleSubmit(event)">
            <!-- Form Login -->
            <div id="login-form" class="form-transition form-transition-active">
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" placeholder="Masukkan Email Anda" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                </div>
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" placeholder="Masukkan Password" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                </div>
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-users-cog input-icon"></i>
                    <select name="role" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out" name="masukUser">Masuk</button>
                <p class="mt-4 text-center">
                    <span class="text-black-500 cursor-pointer" onclick="toggleForm()">Belum punya akun? Daftar di sini</span>
                </p>
            </div>
        </form>

        <!-- Form Registrasi -->
        <form id="form" action="#" method="POST" onsubmit="handleSubmit(event)">
            <div id="registration-form" class="form-transition">
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" name="nama" placeholder="Nama Lengkap" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                </div>
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" name="email" placeholder="Masukkan Email Anda" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                </div>
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-phone input-icon"></i>
                    <input type="tel" name="no_telp" placeholder="No. Telepon (contoh: 08123456789)" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                </div>
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="password" placeholder="Masukkan Password" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                </div>
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                </div>
                <div class="mb-4 input-wrapper">
                    <i class="fas fa-map-marker-alt input-icon"></i>
                    <input type="text" name="alamat" placeholder="Alamat Lengkap" required class="input-field border border-gray-300 rounded-lg p-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white p-3 rounded-lg hover:bg-blue-600 transition duration-300 ease-in-out" name="daftarUser">Daftar</button>
                <p class="mt-4 text-center">
                    <span class="text-black-500 cursor-pointer" onclick="toggleForm()">Sudah punya akun? Masuk di sini</span>
                </p>
            </div>
        </form>

    </div>
    <script>
        function toggleForm() {
            const loginForm = document.getElementById('login-form');
            const registrationForm = document.getElementById('registration-form');
            const formTitle = document.getElementById('form-title');

            if (loginForm.classList.contains('form-transition-active')) {
                // Hiding login form
                loginForm.classList.remove('form-transition-active');
                registrationForm.style.display = 'block';
                setTimeout(() => {
                    registrationForm.classList.add('form-transition-active');
                    formTitle.textContent = 'Registrasi';
                }, 10);
                setTimeout(() => {
                    loginForm.style.display = 'none';
                }, 400);
            } else {
                // Hiding registration form
                registrationForm.classList.remove('form-transition-active');
                loginForm.style.display = 'block';
                setTimeout(() => {
                    loginForm.classList.add('form-transition-active');
                    formTitle.textContent = 'Login';
                }, 10);
                setTimeout(() => {
                    registrationForm.style.display = 'none';
                }, 400);
            }
        }
    </script>
</body>

</html>