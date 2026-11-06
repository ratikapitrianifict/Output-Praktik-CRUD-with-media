<?php
/**
 * Halaman Dashboard Utama (pages/dashboard.php)
 * Modul 5B, Modul 08 & Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

$total_mhs = 0;
$query_count = $conn->query("SELECT COUNT(*) AS total FROM mahasiswa");
if ($query_count) {
    $row_count = $query_count->fetch_assoc();
    $total_mhs = (int) ($row_count["total"] ?? 0);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Dashboard Application Lab</h1>
        <p>Tugas Praktik Web Programming 1 - Authentication, Session, dan CRUD</p>
    </header>

    <nav>
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="index.php">Biodata</a>
        <a href="layout.php">Layout Lab</a>
        <a href="data_mahasiswa.php">Data Mahasiswa</a>
        <a href="form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../crud/index.php">CRUD Mahasiswa</a>
        <a href="../crud-media/index.php">CRUD Media</a>
        <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
    </nav>

    <main>
        <section class="card">
            <h2>Selamat Datang</h2>
            <p>
                Selamat datang, <strong><?= htmlspecialchars($_SESSION["nama_lengkap"]); ?></strong>.
            </p>
            <div class="message sukses">
                Status Autentikasi: Anda telah berhasil masuk dan sesi pengguna saat ini aktif.
            </div>
            <p class="text-muted">
                Halaman ini dilindungi oleh sistem autentikasi pada <code>config/auth.php</code>. Pengguna yang belum memiliki sesi aktif tidak dapat mengakses halaman internal maupun pengelolaan data mahasiswa.
            </p>
        </section>

        <div class="dashboard-grid">
            <div class="card">
                <h3>Ringkasan Data Mahasiswa</h3>
                <p class="stat-number">
                    <?= $total_mhs; ?> <span class="stat-unit">Data Terdaftar</span>
                </p>
                <p class="text-muted">
                    Terhubung dengan database MySQL <code>web_programming_1</code>.
                </p>
                <div class="link-group">
                    <a href="data_mahasiswa.php" class="text-link">Data Mahasiswa</a>
                    <a href="../crud/index.php" class="text-link">CRUD Mahasiswa</a>
                    <a href="../crud-media/index.php" class="text-link">CRUD Media</a>
                </div>
            </div>

            <div class="card">
                <h3>Informasi Sesi Akun</h3>
                <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION["username"]); ?></p>
                <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($_SESSION["nama_lengkap"]); ?></p>
                <p><strong>Status Sesi:</strong> <span class="status-active">Aktif</span></p>
                <a href="../proses/logout.php" class="text-link-danger">Akhiri Sesi (Logout)</a>
            </div>
        </div>

        <section class="card">
            <h3>Navigasi Modul Aplikasi</h3>
            <div class="link-group">
                <a href="../crud-media/index.php" class="btn-action btn-primary">Kelola CRUD Media (Modul 10)</a>
                <a href="../crud/index.php" class="btn-action">Kelola CRUD Mahasiswa (Modul 08)</a>
                <a href="data_mahasiswa.php" class="btn-action">Data Mahasiswa (Modul 3B/4B)</a>
                <a href="form_mahasiswa.php" class="btn-action">Form Tambah Mahasiswa (Modul 4B)</a>
                <a href="../proses/logout.php" class="btn-action btn-danger">Logout</a>
            </div>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 - Web Programming 1</p>
    </footer>

</body>
</html>
<?php
$conn->close();
?>
