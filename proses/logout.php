<?php
/**
 * Logout System (proses/logout.php)
 * Modul 5B & Modul 08 - Web Programming 1
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Kosongkan semua data session
$_SESSION = [];

// 2. Hapus session cookie di browser jika ada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// 3. Hancurkan session di server
session_destroy();

// 4. Redirect ke halaman login dengan notifikasi logout
header("Location: ../pages/login.php?pesan=logout");
exit;
?>
