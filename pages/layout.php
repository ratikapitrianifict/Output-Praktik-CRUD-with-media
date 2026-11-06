<?php
/**
 * Halaman Layout Lab (pages/layout.php)
 * Modul 4A & Modul 08 - Web Programming 1
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Lab - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Layout Lab</h1>
        <p>Demonstrasi CSS Box Model dan Struktur Tata Letak (Modul 4A)</p>
    </header>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php">Biodata</a>
        <a href="layout.php" class="active">Layout Lab</a>
        <a href="data_mahasiswa.php">Data Mahasiswa</a>
        <a href="form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../crud/index.php">CRUD Mahasiswa</a>
        <a href="../crud-media/index.php">CRUD Media</a>
        <?php if ($is_logged_in): ?>
            <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
        <?php else: ?>
            <a href="login.php" class="nav-login">Login</a>
        <?php endif; ?>
    </nav>

    <main>
        <section class="card">
            <h2>Konsep CSS Box Model</h2>
            <p>
                Setiap elemen HTML direpresentasikan sebagai kotak persegi panjang yang tersusun atas empat lapisan utama: <strong>Content</strong>, <strong>Padding</strong>, <strong>Border</strong>, dan <strong>Margin</strong>.
            </p>
            <div class="demo-box">
                <p class="demo-box-title">Area Demonstrasi Box Model</p>
                <p class="demo-box-desc">Penerapan properti universal <code>box-sizing: border-box</code> memastikan lebar dan tinggi elemen mencakup padding serta border secara konsisten.</p>
            </div>
        </section>

        <section class="card">
            <h2>Penerapan Properti Display: Inline-Block</h2>
            <p>Komponen tautan di bawah ini menggunakan properti <code>display: inline-block</code> sehingga dapat diatur dimensi ruang dalamnya tanpa kehilangan alur horizontal:</p>
            <div class="link-group">
                <a href="index.php" class="btn-action">HTML5 Semantik</a>
                <a href="layout.php" class="btn-action">CSS3 Box Model</a>
                <a href="data_mahasiswa.php" class="btn-action">Integrasi MySQL</a>
                <a href="../crud/index.php" class="btn-action">Modul CRUD Teks</a>
                <a href="../crud-media/index.php" class="btn-action">Modul CRUD Media</a>
            </div>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 - Web Programming 1</p>
    </footer>

</body>
</html>
