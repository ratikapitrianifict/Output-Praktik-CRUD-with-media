<?php
/**
 * File Koneksi Database (config/koneksi.php)
 * Modul 08 - Web Programming 1
 */

$host     = "localhost";
$user     = "root";
$password = "";
$database = "web_programming_1";

// Mengaktifkan pelaporan error MySQLi
mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli($host, $user, $password);

if ($conn->connect_error) {
    die("Koneksi MySQL gagal: " . $conn->connect_error . ". Pastikan MySQL di Laragon sudah aktif (Start All).");
}

// Buat database web_programming_1 jika belum ada
$conn->query("CREATE DATABASE IF NOT EXISTS `$database`");
if (!$conn->select_db($database)) {
    die("Gagal memilih database $database: " . $conn->error);
}

$conn->set_charset("utf8mb4");
?>
