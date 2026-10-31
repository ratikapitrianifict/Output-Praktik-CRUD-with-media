<?php
/**
 * Backend Pemrosesan Login (proses/proses_login.php)
 * Modul 5B & Modul 08 - Web Programming 1
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../config/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../pages/login.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$password = $_POST["password"] ?? "";

if ($username === "" || $password === "") {
    header("Location: ../pages/login.php?error=1");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
if (!$stmt) {
    die("Gagal menyiapkan query: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();

$hash = $user["password"] ?? $user["password_hash"] ?? "";

if ($user && ($hash !== "" && password_verify($password, $hash))) {
    // Regenerasi session ID untuk keamanan
    session_regenerate_id(true);

    $_SESSION["user_id"]      = $user["id"];
    $_SESSION["username"]     = $user["username"];
    $_SESSION["nama_lengkap"] = $user["nama_lengkap"];

    $stmt->close();
    $conn->close();

    header("Location: ../pages/dashboard.php");
    exit;
}

$stmt->close();
$conn->close();

header("Location: ../pages/login.php?error=1");
exit;
?>
