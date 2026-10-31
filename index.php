<?php
/**
 * Root Entry Point (index.php)
 * Modul 08 - Web Programming 1
 * Mengarahkan pengunjung ke halaman yang sesuai (dashboard jika sudah login, atau login jika belum).
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION["user_id"])) {
    header("Location: pages/dashboard.php");
} else {
    header("Location: pages/login.php");
}
exit;
?>
