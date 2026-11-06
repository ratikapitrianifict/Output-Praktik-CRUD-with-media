<?php
/**
 * Halaman Edit Data CRUD Mahasiswa (crud/edit.php)
 * Modul 08 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

$id = (int) ($_GET["id"] ?? 0);
if ($id <= 0) {
    die("ID tidak valid.");
}

$stmt = $conn->prepare(
    "SELECT id, nim, nama, program_studi, email
     FROM mahasiswa
     WHERE id = ?
     LIMIT 1"
);

if (!$stmt) {
    die("Gagal menyiapkan query: " . htmlspecialchars($conn->error));
}

$stmt->bind_param("i", $id);
$stmt->execute();
$mahasiswa = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$mahasiswa) {
    $conn->close();
    die("Data mahasiswa tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Edit Data Mahasiswa</h1>
        <p>Pembaruan Informasi Data Mahasiswa (Modul 08)</p>
    </header>

    <nav>
        <a href="../pages/dashboard.php">Dashboard</a>
        <a href="../pages/index.php">Biodata</a>
        <a href="../pages/layout.php">Layout Lab</a>
        <a href="../pages/data_mahasiswa.php">Data Mahasiswa</a>
        <a href="../pages/form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="index.php" class="active">CRUD Mahasiswa</a>
        <a href="../crud-media/index.php">CRUD Media</a>
        <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
    </nav>

    <main>
        <section class="card">
            <div class="form-header">
                <h2>Formulir Pembaruan Data Mahasiswa</h2>
                <p>Perbarui informasi pada kolom berikut lalu pilih tombol <strong>Update Data</strong>.</p>
            </div>

            <form
                class="crud-form"
                data-crud-form
                action="../proses/proses_update.php"
                method="POST"
                novalidate
            >
                <input type="hidden" name="id" value="<?= (int) $mahasiswa["id"]; ?>">

                <label for="nim">NIM</label>
                <input
                    id="nim"
                    name="nim"
                    type="text"
                    value="<?= htmlspecialchars($mahasiswa["nim"]); ?>"
                    required
                >
                <small class="form-error" id="errorNim"></small>

                <label for="nama">Nama Lengkap</label>
                <input
                    id="nama"
                    name="nama"
                    type="text"
                    value="<?= htmlspecialchars($mahasiswa["nama"]); ?>"
                    required
                >
                <small class="form-error" id="errorNama"></small>

                <label for="program_studi">Program Studi</label>
                <input
                    id="program_studi"
                    name="program_studi"
                    type="text"
                    value="<?= htmlspecialchars($mahasiswa["program_studi"]); ?>"
                    required
                >
                <small class="form-error" id="errorProdi"></small>

                <label for="email">Email</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="<?= htmlspecialchars($mahasiswa["email"]); ?>"
                    required
                >
                <small class="form-error" id="errorEmail"></small>

                <div class="form-actions">
                    <button type="submit">Update Data</button>
                    <a href="index.php">Batal</a>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 - Web Programming 1</p>
    </footer>

    <script src="../assets/js/crud.js"></script>
</body>
</html>
<?php
$conn->close();
?>
