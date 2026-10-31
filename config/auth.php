<?php
/**
 * File Keamanan Session Guard (config/auth.php)
 * Modul 08 - Web Programming 1
 * Diletakkan di baris paling atas pada setiap halaman yang membutuhkan login.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah session user_id sudah ada
if (!isset($_SESSION["user_id"])) {
    header("Location: ../pages/login.php?pesan=belum_login");
    exit;
}
?>
