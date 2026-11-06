<?php
/**
 * Backend Pemroses Hapus CRUD Mahasiswa (proses/proses_hapus.php)
 * Modul 08 & Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";
require_once __DIR__ . "/../config/media_helper.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../crud/index.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);
if ($id <= 0) {
    die("ID tidak valid.");
}

// Ambil informasi file media (jika ada) agar tidak meninggalkan file yatim (orphan file)
$stmtSelect = $conn->prepare("SELECT foto, audio, dokumen FROM mahasiswa WHERE id = ? LIMIT 1");
$dataMedia = null;
if ($stmtSelect) {
    $stmtSelect->bind_param("i", $id);
    $stmtSelect->execute();
    $dataMedia = $stmtSelect->get_result()->fetch_assoc();
    $stmtSelect->close();
}

$stmt = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
if (!$stmt) {
    die("Gagal menyiapkan query hapus: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();
$conn->close();

// Bersihkan file media terkait jika record tersebut memiliki file
if ($dataMedia) {
    $rootUpload = __DIR__ . "/../uploads";
    hapusMediaJikaAda($dataMedia["foto"] ?? null, $rootUpload . "/images");
    hapusMediaJikaAda($dataMedia["audio"] ?? null, $rootUpload . "/audio");
    hapusMediaJikaAda($dataMedia["dokumen"] ?? null, $rootUpload . "/documents");
}

header("Location: ../crud/index.php?status=hapus");
exit;
?>
