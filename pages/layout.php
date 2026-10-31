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
        <p>Eksperimen CSS Box Model &amp; Struktur Spacing (Modul 4A)</p>
    </header>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php">Biodata</a>
        <a href="layout.php" class="active">Layout Lab</a>
        <a href="data_mahasiswa.php">Data Mahasiswa</a>
        <a href="form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../crud/index.php">Mahasiswa</a>
        <?php if ($is_logged_in): ?>
            <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
        <?php else: ?>
            <a href="login.php" style="background-color: #1f4e79; color: white;">Login System &raquo;</a>
        <?php endif; ?>
    </nav>

    <main>
        <section class="card">
            <h2>Eksperimen Box Model</h2>
            <p>
                Setiap elemen adalah box yang memiliki 4 lapisan: <strong>Content</strong>, <strong>Padding</strong>, <strong>Border</strong>, dan <strong>Margin</strong>.
            </p>
            <div style="background: #eef3f8; border: 2px dashed #93c5fd; padding: 20px; border-radius: 8px; margin-top: 14px;">
                <p style="margin: 0; font-weight: bold; color: #1e3a8a;">Box Demonstrasi</p>
                <p style="margin: 6px 0 0 0; color: #3b82f6;">Universal box-sizing: border-box membuat perhitungan ukuran elemen konsisten dan mudah diprediksi.</p>
            </div>
        </section>

        <section class="card">
            <h2>Demonstrasi Display: Inline-Block</h2>
            <p>Elemen navigasi di bawah ini menggunakan <code>display: inline-block</code> dengan padding dan border:</p>
            <div style="margin-top: 10px;">
                <a href="#" class="btn-action">HTML5</a>
                <a href="#" class="btn-action">CSS3 Box Model</a>
                <a href="#" class="btn-action">PHP Server</a>
                <a href="#" class="btn-action">MySQL Database</a>
                <a href="#" class="btn-action">JavaScript CRUD</a>
            </div>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 - Web Programming 1</p>
    </footer>

</body>
</html>
