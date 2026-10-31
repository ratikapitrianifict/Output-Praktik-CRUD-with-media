<?php
/**
 * Halaman Login (pages/login.php)
 * Modul 5B & Modul 08 - Web Programming 1
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika sudah login, langsung alihkan ke dashboard
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
        <h2>Login</h2>
        <p style="color: #64748b; margin-top: -6px; margin-bottom: 20px;">
            Masuk untuk membuka Application Lab.
        </p>

        <?php if (isset($_GET["error"]) && $_GET["error"] == "1"): ?>
            <div class="message error">
                Username atau password salah.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET["pesan"]) && $_GET["pesan"] == "logout"): ?>
            <div class="message sukses">
                Anda sudah logout.
            </div>
        <?php elseif (isset($_GET["pesan"]) && $_GET["pesan"] == "belum_login"): ?>
            <div class="message info">
                Silakan login terlebih dahulu untuk mengakses halaman tersebut.
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

            <button type="submit" id="btn-login">Login</button>
        </form>

        <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #e2e8f0; font-size: 13px; color: #64748b; text-align: center;">
            <p style="margin: 4px 0;">Belum punya akun admin? <a href="../proses/buat_user.php" style="color: #1f4e79; font-weight: 600;">Jalankan Inisialisasi Akun</a></p>
            <p style="margin: 4px 0;"><a href="index.php" style="color: #64748b; text-decoration: none;">&larr; Kembali ke Biodata Publik</a></p>
        </div>
    </div>

</body>
</html>
