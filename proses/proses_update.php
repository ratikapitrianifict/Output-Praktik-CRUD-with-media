<?php
/**
 * Backend Pemroses Update CRUD Mahasiswa (proses/proses_update.php)
 * Modul 08 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../crud/index.php");
    exit;
}

$id            = (int) ($_POST["id"] ?? 0);
$nim           = trim($_POST["nim"] ?? "");
$nama          = trim($_POST["nama"] ?? "");
$program_studi = trim($_POST["program_studi"] ?? "");
$email         = trim($_POST["email"] ?? "");

if ($id <= 0 || $nim === "" || $nama === "" || $program_studi === "" || $email === "") {
    die("Data update tidak valid.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Format email tidak valid.");
}

$stmt = $conn->prepare(
    "UPDATE mahasiswa
     SET nim = ?, nama = ?, program_studi = ?, email = ?
     WHERE id = ?"
);

if (!$stmt) {
    die("Gagal menyiapkan query: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("ssssi", $nim, $nama, $program_studi, $email, $id);

if (!$stmt->execute()) {
    $err = $stmt->error;
    $stmt->close();
    $conn->close();
    die("Gagal memperbarui data: " . htmlspecialchars($err));
}

$stmt->close();
$conn->close();

header("Location: ../crud/index.php?status=update");
exit;
?>
