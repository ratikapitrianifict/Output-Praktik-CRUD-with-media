<?php
/**
 * Backend Pemroses Hapus CRUD Media (proses/crud-media/hapus.php)
 * Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../../config/auth.php";
require_once __DIR__ . "/../../config/koneksi.php";
require_once __DIR__ . "/../../config/media_helper.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../crud-media/index.php");
    exit;
}

$id = (int) ($_POST["id"] ?? 0);

if ($id <= 0) {
    die("ID tidak valid.");
}

$stmtSelect = $conn->prepare(
    "SELECT foto, audio, dokumen
     FROM mahasiswa
     WHERE id = ?
     LIMIT 1"
);

if (!$stmtSelect) {
    die("Gagal menyiapkan query: " . htmlspecialchars($conn->error));
}

$stmtSelect->bind_param("i", $id);
$stmtSelect->execute();
$data = $stmtSelect->get_result()->fetch_assoc();
$stmtSelect->close();

if (!$data) {
    $conn->close();
    die("Data tidak ditemukan.");
}

$stmtDelete = $conn->prepare("DELETE FROM mahasiswa WHERE id = ?");
if (!$stmtDelete) {
    $conn->close();
    die("Gagal menyiapkan query hapus: " . htmlspecialchars($conn->error));
}

$stmtDelete->bind_param("i", $id);

if (!$stmtDelete->execute()) {
    $stmtDelete->close();
    $conn->close();
    die("Data gagal dihapus dari database.");
}

$stmtDelete->close();
$conn->close();

$rootUpload = __DIR__ . "/../../uploads";

hapusMediaJikaAda($data["foto"], $rootUpload . "/images");
hapusMediaJikaAda($data["audio"], $rootUpload . "/audio");
hapusMediaJikaAda($data["dokumen"], $rootUpload . "/documents");

header("Location: ../../crud-media/index.php?status=hapus");
exit;
?>
