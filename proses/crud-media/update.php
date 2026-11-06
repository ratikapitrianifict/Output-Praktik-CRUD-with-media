<?php
/**
 * Backend Pemroses Update CRUD Media (proses/crud-media/update.php)
 * Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../../config/auth.php";
require_once __DIR__ . "/../../config/koneksi.php";
require_once __DIR__ . "/../../config/media_helper.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../crud-media/index.php");
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

$stmtOld = $conn->prepare(
    "SELECT foto, audio, dokumen
     FROM mahasiswa
     WHERE id = ?
     LIMIT 1"
);

if (!$stmtOld) {
    die("Gagal menyiapkan query: " . htmlspecialchars($conn->error));
}

$stmtOld->bind_param("i", $id);
$stmtOld->execute();
$lama = $stmtOld->get_result()->fetch_assoc();
$stmtOld->close();

if (!$lama) {
    $conn->close();
    die("Data tidak ditemukan.");
}

$rootUpload  = __DIR__ . "/../../uploads";
$imageDir    = $rootUpload . "/images";
$audioDir    = $rootUpload . "/audio";
$documentDir = $rootUpload . "/documents";

$allowedImage = [
    "image/jpeg" => "jpg",
    "image/png"  => "png",
    "image/webp" => "webp"
];

$allowedAudio = [
    "audio/mpeg"     => "mp3",
    "audio/mp3"      => "mp3",
    "audio/wav"      => "wav",
    "audio/x-wav"    => "wav",
    "audio/wave"     => "wav",
    "audio/vnd.wave" => "wav",
    "audio/x-pn-wav" => "wav"
];

$allowedDocument = [
    "application/pdf"   => "pdf",
    "application/x-pdf" => "pdf"
];

$maxSize = 2 * 1024 * 1024; // 2 MB

$fotoBaru    = null;
$audioBaru   = null;
$dokumenBaru = null;

try {
    $fotoBaru = uploadMedia(
        $_FILES["foto"] ?? [],
        $allowedImage,
        $maxSize,
        $imageDir,
        "img"
    );

    $audioBaru = uploadMedia(
        $_FILES["audio"] ?? [],
        $allowedAudio,
        $maxSize,
        $audioDir,
        "aud"
    );

    $dokumenBaru = uploadMedia(
        $_FILES["dokumen"] ?? [],
        $allowedDocument,
        $maxSize,
        $documentDir,
        "doc"
    );

    $fotoFinal    = $fotoBaru ?? $lama["foto"];
    $audioFinal   = $audioBaru ?? $lama["audio"];
    $dokumenFinal = $dokumenBaru ?? $lama["dokumen"];

    $stmt = $conn->prepare(
        "UPDATE mahasiswa
         SET nim = ?,
             nama = ?,
             program_studi = ?,
             email = ?,
             foto = ?,
             audio = ?,
             dokumen = ?
         WHERE id = ?"
    );

    if (!$stmt) {
        throw new RuntimeException("Gagal menyiapkan query update: " . $conn->error);
    }

    $stmt->bind_param(
        "sssssssi",
        $nim,
        $nama,
        $program_studi,
        $email,
        $fotoFinal,
        $audioFinal,
        $dokumenFinal,
        $id
    );

    if (!$stmt->execute()) {
        $stmtErr = $stmt->error;
        $stmt->close();
        throw new RuntimeException("Update database gagal: " . $stmtErr);
    }

    $stmt->close();

    // Hapus file lama hanya jika ada file baru yang menggantikannya
    if ($fotoBaru !== null) {
        hapusMediaJikaAda($lama["foto"], $imageDir);
    }

    if ($audioBaru !== null) {
        hapusMediaJikaAda($lama["audio"], $audioDir);
    }

    if ($dokumenBaru !== null) {
        hapusMediaJikaAda($lama["dokumen"], $documentDir);
    }

    $conn->close();

    header("Location: ../../crud-media/index.php?status=update");
    exit;
} catch (RuntimeException $e) {
    hapusMediaJikaAda($fotoBaru, $imageDir);
    hapusMediaJikaAda($audioBaru, $audioDir);
    hapusMediaJikaAda($dokumenBaru, $documentDir);

    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }

    die("Proses update gagal: " . htmlspecialchars($e->getMessage()));
}
?>
