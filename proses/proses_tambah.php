<?php
/**
 * Backend Pemroses Tambah Mahasiswa (proses/proses_tambah.php)
 * Modul 4B, 5B, & 08 - Web Programming 1 (Proses Lama, Tetap)
 */

require_once "../config/auth.php";
require_once "../config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../pages/form_mahasiswa.php");
    exit;
}

$nim           = trim($_POST["nim"] ?? "");
$nama          = trim($_POST["nama"] ?? "");
$program_studi = trim($_POST["program_studi"] ?? "");
$email         = trim($_POST["email"] ?? "");

if ($nim === "" || $nama === "" || $program_studi === "" || $email === "") {
    die("Semua field wajib diisi. Silakan kembali ke form.");
}

$stmt = $conn->prepare(
    "INSERT INTO mahasiswa (nim, nama, program_studi, email) VALUES (?, ?, ?, ?)"
);

if (!$stmt) {
    die("Gagal menyiapkan query: " . $conn->error);
}

$stmt->bind_param(
    "ssss",
    $nim,
    $nama,
    $program_studi,
    $email
);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../pages/data_mahasiswa.php?status=sukses");
    exit;
} else {
    echo "Gagal menyimpan data: " . $stmt->error;
    $stmt->close();
    $conn->close();
}
?>
