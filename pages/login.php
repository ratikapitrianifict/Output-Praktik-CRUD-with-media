<?php
/**
 * Halaman Login (pages/login.php)
 * Modul 5B & Modul 08 - Web Programming 1
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">

    <div class="login-card">
        <h2>Autentikasi Pengguna</h2>
        <p class="section-subtitle">
            Silakan masuk untuk mengakses sistem Application Lab.
        </p>

        <?php if (isset($_GET["error"]) && $_GET["error"] === "1"): ?>
            <div class="message error">
                Username atau password yang Anda masukkan tidak sesuai.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET["pesan"]) && $_GET["pesan"] === "logout"): ?>
            <div class="message sukses">
                Sesi Anda telah berhasil diakhiri.
            </div>
        <?php elseif (isset($_GET["pesan"]) && $_GET["pesan"] === "belum_login"): ?>
            <div class="message info">
                Silakan masuk terlebih dahulu untuk mengakses halaman tersebut.
            </div>
        <?php endif; ?>

        <form action="../proses/proses_login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" id="btn-login">Masuk</button>
        </form>

        <div class="login-footer">
            <p>Belum memiliki akun administrator? <a href="../proses/buat_user.php" class="text-link">Inisialisasi Akun</a></p>
            <p><a href="index.php" class="text-muted" style="text-decoration: none;">Kembali ke Halaman Biodata Publik</a></p>
        </div>
    </div>

</body>
</html>
