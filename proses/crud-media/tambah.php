<?php
/**
 * Backend Pemroses Tambah CRUD Media (proses/crud-media/tambah.php)
 * Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../../config/auth.php";
require_once __DIR__ . "/../../config/koneksi.php";
require_once __DIR__ . "/../../config/media_helper.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../../crud-media/tambah.php");
    exit;
}

$nim           = trim($_POST["nim"] ?? "");
$nama          = trim($_POST["nama"] ?? "");
$program_studi = trim($_POST["program_studi"] ?? "");
$email         = trim($_POST["email"] ?? "");

if ($nim === "" || $nama === "" || $program_studi === "" || $email === "") {
    die("Semua field teks wajib diisi.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Format email tidak valid.");
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

$foto    = null;
$audio   = null;
$dokumen = null;

try {
    $foto = uploadMedia(
        $_FILES["foto"] ?? [],
        $allowedImage,
        $maxSize,
        $imageDir,
        "img"
    );

    if ($foto === null) {
        throw new RuntimeException("Foto wajib dipilih.");
    }

    $audio = uploadMedia(
        $_FILES["audio"] ?? [],
        $allowedAudio,
        $maxSize,
        $audioDir,
        "aud"
    );

    $dokumen = uploadMedia(
        $_FILES["dokumen"] ?? [],
        $allowedDocument,
        $maxSize,
        $documentDir,
        "doc"
    );

    $stmt = $conn->prepare(
        "INSERT INTO mahasiswa
         (nim, nama, program_studi, email, foto, audio, dokumen)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );

    if (!$stmt) {
        throw new RuntimeException("Gagal menyiapkan query database: " . $conn->error);
    }

    $stmt->bind_param(
        "sssssss",
        $nim,
        $nama,
        $program_studi,
        $email,
        $foto,
        $audio,
        $dokumen
    );

    if (!$stmt->execute()) {
        $stmtErr = $stmt->error;
        $stmt->close();
        throw new RuntimeException("Data gagal disimpan ke database: " . $stmtErr);
    }

    $stmt->close();
    $conn->close();

    header("Location: ../../crud-media/index.php?status=tambah");
    exit;
} catch (RuntimeException $e) {
    hapusMediaJikaAda($foto, $imageDir);
    hapusMediaJikaAda($audio, $audioDir);
    hapusMediaJikaAda($dokumen, $documentDir);

    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }

    die("Proses gagal: " . htmlspecialchars($e->getMessage()));
}
?>
