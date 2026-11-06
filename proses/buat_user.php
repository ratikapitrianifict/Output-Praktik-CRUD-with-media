<?php
/**
 * File Inisialisasi User Awal & Tabel (proses/buat_user.php)
 * Modul 5B, Modul 08 & Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../config/koneksi.php";

$username     = "admin";
$password     = "123";
$nama_lengkap = "Administrator Lab";

// 1. Buat tabel users jika belum ada
$sql_tabel_users = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `nama_lengkap` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

if (!$conn->query($sql_tabel_users)) {
    die("Gagal membuat tabel users: " . htmlspecialchars($conn->error));
}

// Deteksi nama kolom password pada tabel users (mendukung 'password_hash' maupun 'password')
$passCol = "password_hash";
$userColsRes = $conn->query("SHOW COLUMNS FROM `users`");
if ($userColsRes) {
    $userCols = [];
    while ($uc = $userColsRes->fetch_assoc()) {
        $userCols[$uc["Field"]] = true;
    }
    if (!isset($userCols["password_hash"]) && isset($userCols["password"])) {
        $passCol = "password";
    }
}

// 2. Buat tabel mahasiswa beserta kolom media (Modul 08 + Modul 10) jika belum ada
$sql_tabel_mhs = "CREATE TABLE IF NOT EXISTS `mahasiswa` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nim` VARCHAR(20) NOT NULL,
    `nama` VARCHAR(100) NOT NULL,
    `program_studi` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `foto` VARCHAR(255) NULL,
    `audio` VARCHAR(255) NULL,
    `dokumen` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
$conn->query($sql_tabel_mhs);

// Masukkan data awal mahasiswa jika tabel masih kosong
$cek_mhs = $conn->query("SELECT id FROM mahasiswa LIMIT 1");
if ($cek_mhs && $cek_mhs->num_rows === 0) {
    $conn->query("INSERT INTO mahasiswa (nim, nama, program_studi, email, foto, audio, dokumen) VALUES
        ('230001', 'Andi Pratama', 'Informatika', 'andi@email.com', NULL, NULL, NULL),
        ('230002', 'Budi Santoso', 'Sistem Informasi', 'budi@email.com', NULL, NULL, NULL),
        ('230003', 'Citra Lestari', 'Informatika', 'citra@email.com', NULL, NULL, NULL),
        ('230004', 'Dewi Anggraini', 'Teknologi Informasi', 'dewi@email.com', NULL, NULL, NULL)");
}

// 3. Cek apakah user admin sudah ada
$cek = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
$cek->bind_param("s", $username);
$cek->execute();
$hasil_cek = $cek->get_result();

$pesan  = "";
$status = "";

if ($row_admin = $hasil_cek->fetch_assoc()) {
    $cek->close();
    $existingHash = $row_admin["password"] ?? $row_admin["password_hash"] ?? "";

    // Jika hash kosong atau rusak (kurang dari 60 karakter bcrypt), perbaiki otomatis
    if (strlen($existingHash) < 60) {
        $new_hash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $conn->prepare("UPDATE users SET `$passCol` = ? WHERE id = ?");
        $upd->bind_param("si", $new_hash, $row_admin["id"]);
        $upd->execute();
        $upd->close();
        $pesan  = "Akun <strong>admin</strong> telah diperbarui dan siap digunakan.<br>Username: <strong>admin</strong> | Password: <strong>123</strong>";
        $status = "sukses";
    } else {
        $pesan  = "Akun <strong>admin</strong> sudah tersedia di database <code>web_programming_1</code>. Silakan melanjutkan ke halaman login.";
        $status = "info";
    }
} else {
    $cek->close();

    // Hash password dan simpan user baru
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, `$passCol`, nama_lengkap) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password_hash, $nama_lengkap);

    if ($stmt->execute()) {
        $pesan  = "Akun administrator berhasil dibuat.<br>Username: <strong>admin</strong> | Password: <strong>123</strong>";
        $status = "sukses";
    } else {
        $pesan  = "Gagal membuat akun pengguna: " . htmlspecialchars($stmt->error);
        $status = "error";
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inisialisasi Akun Administrator - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
    <div class="login-card">
        <h2 style="text-align: center; margin-bottom: 16px;">Inisialisasi Database</h2>
        <div class="message <?= $status === 'error' ? 'error' : ($status === 'info' ? 'info' : 'sukses'); ?>">
            <?= $pesan; ?>
        </div>
        <div style="text-align: center; margin-top: 20px;">
            <a href="../pages/login.php" class="btn" style="display: block; width: 100%; text-align: center; padding: 12px 20px;">
                Kembali ke Halaman Login
            </a>
        </div>
    </div>
</body>
</html>
