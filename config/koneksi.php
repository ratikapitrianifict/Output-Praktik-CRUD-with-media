<?php
/**
 * File Koneksi Database (config/koneksi.php)
 * Modul 08 & Modul 10 - Web Programming 1
 */

$host     = "localhost";
$user     = "root";
$password = "";
$database = "web_programming_1";

// Nonaktifkan exception otomatis agar error dapat ditangani secara terkontrol
mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli($host, $user, $password);

if ($conn->connect_error) {
    die("Koneksi MySQL gagal: " . $conn->connect_error . ". Pastikan MySQL di Laragon sudah aktif (Start All).");
}

// Buat database web_programming_1 jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS `$database` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
if (!$conn->select_db($database)) {
    die("Gagal memilih database $database: " . $conn->error);
}

$conn->set_charset("utf8mb4");

// Pastikan tabel mahasiswa tersedia beserta kolom media (Modul 10)
$conn->query("CREATE TABLE IF NOT EXISTS `mahasiswa` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nim` VARCHAR(20) NOT NULL,
    `nama` VARCHAR(100) NOT NULL,
    `program_studi` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `foto` VARCHAR(255) NULL,
    `audio` VARCHAR(255) NULL,
    `dokumen` VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

// Auto-upgrade tabel mahasiswa lama (Modul 08 -> Modul 10) jika kolom media belum ada
$existingCols = [];
$colResult = $conn->query("SHOW COLUMNS FROM `mahasiswa`");
if ($colResult) {
    while ($colRow = $colResult->fetch_assoc()) {
        $existingCols[$colRow["Field"]] = true;
    }
    $colResult->free();
}

$mediaColumns = [
    "foto"    => "ALTER TABLE `mahasiswa` ADD `foto` VARCHAR(255) NULL",
    "audio"   => "ALTER TABLE `mahasiswa` ADD `audio` VARCHAR(255) NULL",
    "dokumen" => "ALTER TABLE `mahasiswa` ADD `dokumen` VARCHAR(255) NULL"
];

foreach ($mediaColumns as $colName => $alterSql) {
    if (!isset($existingCols[$colName])) {
        $conn->query($alterSql);
    }
}
?>
