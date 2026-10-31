<?php
/**
 * File Inisialisasi User Awal & Tabel (proses/buat_user.php)
 * Modul 5B & Modul 08 - Web Programming 1
 */

require_once "../config/koneksi.php";

$username = "admin";
$password = "123";
$nama_lengkap = "Administrator Lab";

// 1. Buat tabel users jika belum ada
$sql_tabel_users = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!$conn->query($sql_tabel_users)) {
    die("Gagal membuat tabel users: " . $conn->error);
}

// 2. Buat tabel mahasiswa (Modul 3B / 4B) jika belum ada
$sql_tabel_mhs = "CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nim VARCHAR(20) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    program_studi VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL
)";
$conn->query($sql_tabel_mhs);

// Masukkan data dummy mahasiswa jika tabel masih kosong
$cek_mhs = $conn->query("SELECT id FROM mahasiswa LIMIT 1");
if ($cek_mhs && $cek_mhs->num_rows === 0) {
    $conn->query("INSERT INTO mahasiswa (nim, nama, program_studi, email) VALUES
        ('230001', 'Andi Pratama', 'Informatika', 'andi@email.com'),
        ('230002', 'Budi Santoso', 'Sistem Informasi', 'budi@email.com'),
        ('230003', 'Citra Lestari', 'Informatika', 'citra@email.com'),
        ('230004', 'Dewi Anggraini', 'Teknologi Informasi', 'dewi@email.com')");
}

// 3. Cek apakah user admin sudah ada
$cek = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
$cek->bind_param("s", $username);
$cek->execute();
$hasil_cek = $cek->get_result();

$pesan = "";
$status = "";

if ($hasil_cek->num_rows > 0) {
    $pesan = "User admin sudah ada di database <code>web_programming_1</code>. Silakan lanjut ke halaman login.";
    $status = "info";
} else {
    $cek->close();

    // Hash password dan simpan user baru
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, nama_lengkap) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password_hash, $nama_lengkap);

    if ($stmt->execute()) {
        $pesan = "User admin berhasil dibuat! <br>Username: <strong>admin</strong> | Password: <strong>123</strong>";
        $status = "sukses";
    } else {
        $pesan = "Gagal membuat user: " . $stmt->error;
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
    <title>Inisialisasi User Admin - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="auth-page">
    <div class="login-card">
        <h2 style="margin-top:0; text-align:center;">Inisialisasi Database</h2>
        <div class="message <?= $status === 'error' ? 'error' : 'sukses'; ?>" style="border-radius: 8px;">
            <?= $pesan; ?>
        </div>
        <p style="text-align:center; margin-top:20px;">
            <a href="../pages/login.php" style="display:inline-block; padding:10px 20px; background-color:#1f4e79; color:#fff; text-decoration:none; border-radius:8px; font-weight:bold;">
                Ke Halaman Login &raquo;
            </a>
        </p>
    </div>
</body>
</html>
