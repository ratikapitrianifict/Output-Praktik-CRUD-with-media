<?php
/**
 * Halaman Edit Data CRUD Media (crud-media/edit.php)
 * Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    die("ID tidak valid.");
}

$stmt = $conn->prepare(
    "SELECT id, nim, nama, program_studi, email, foto, audio, dokumen
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
    <title>Edit CRUD Media - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Edit Data Media</h1>
        <p>Pembaruan Data Mahasiswa dan File Media (Modul 10)</p>
    </header>

    <nav>
        <a href="../pages/dashboard.php">Dashboard</a>
        <a href="../pages/index.php">Biodata</a>
        <a href="../pages/layout.php">Layout Lab</a>
        <a href="../pages/data_mahasiswa.php">Data Mahasiswa</a>
        <a href="../pages/form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../crud/index.php">CRUD Mahasiswa</a>
        <a href="index.php" class="active">CRUD Media</a>
        <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
    </nav>

    <main>
        <section class="card">
            <div class="form-header">
                <h2>Formulir Pembaruan Data dan Media</h2>
                <p>Biarkan kolom unggah file kosong apabila tidak ingin mengganti file media yang telah tersimpan.</p>
            </div>

            <form
                class="crud-form"
                data-media-form
                data-require-foto="false"
                action="../proses/crud-media/update.php"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $mahasiswa["id"]; ?>"
                >

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

                <div class="current-media">
                    <strong>Foto Tersimpan Saat Ini:</strong><br>
                    <?php if (!empty($mahasiswa["foto"])): ?>
                        <img
                            class="media-preview-image"
                            src="../uploads/images/<?= htmlspecialchars($mahasiswa["foto"]); ?>"
                            alt="Foto saat ini"
                        >
                    <?php else: ?>
                        <span class="file-hint">Belum ada foto tersimpan.</span>
                    <?php endif; ?>
                </div>

                <label for="foto">Ganti Foto (Opsional, JPG/PNG/WEBP, Maksimal 2 MB)</label>
                <input id="foto" name="foto" type="file" accept="image/jpeg,image/png,image/webp">
                <small class="form-error" id="errorFoto"></small>

                <div class="media-preview-box">
                    <strong>Pratinjau Foto Baru</strong>
                    <span class="file-hint" id="emptyPreviewFoto">Belum ada foto baru dipilih.</span>
                    <img id="previewFoto" class="media-preview-image" alt="Pratinjau foto baru" hidden>
                </div>

                <div class="current-media">
                    <strong>Audio Tersimpan Saat Ini:</strong><br>
                    <?php if (!empty($mahasiswa["audio"])): ?>
                        <audio controls preload="none" class="media-preview-audio">
                            <source src="../uploads/audio/<?= htmlspecialchars($mahasiswa["audio"]); ?>">
                        </audio>
                    <?php else: ?>
                        <span class="file-hint">Belum ada audio tersimpan.</span>
                    <?php endif; ?>
                </div>

                <label for="audio">Ganti Audio (Opsional, MP3/WAV, Maksimal 2 MB)</label>
                <input id="audio" name="audio" type="file" accept="audio/mpeg,audio/wav,.mp3,.wav">
                <small class="form-error" id="errorAudio"></small>

                <div class="media-preview-box">
                    <strong>Pratinjau Audio Baru</strong>
                    <span class="file-hint" id="emptyPreviewAudio">Belum ada audio baru dipilih.</span>
                    <audio id="previewAudio" class="media-preview-audio" controls hidden></audio>
                </div>

                <div class="current-media">
                    <strong>Dokumen Tersimpan Saat Ini:</strong>
                    <?php if (!empty($mahasiswa["dokumen"])): ?>
                        <a
                            class="pdf-link"
                            href="../uploads/documents/<?= htmlspecialchars($mahasiswa["dokumen"]); ?>"
                            target="_blank"
                            rel="noopener"
                            style="margin-left: 8px;"
                        >Buka PDF</a>
                    <?php else: ?>
                        <span class="file-hint" style="display: inline; margin-left: 6px;">Belum ada dokumen tersimpan.</span>
                    <?php endif; ?>
                </div>

                <label for="dokumen">Ganti Dokumen PDF (Opsional, Maksimal 2 MB)</label>
                <input id="dokumen" name="dokumen" type="file" accept="application/pdf,.pdf">
                <small class="form-error" id="errorDokumen"></small>

                <div class="media-preview-box">
                    <strong>Informasi Dokumen Baru</strong>
                    <p id="previewDokumen" class="file-hint" style="margin: 4px 0 0 0;">Belum ada dokumen baru dipilih.</p>
                </div>

                <div class="form-actions">
                    <button type="submit">Update Data Media</button>
                    <a href="index.php">Batal</a>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 - Web Programming 1</p>
    </footer>

    <script src="../assets/js/media.js"></script>
</body>
</html>
<?php
$conn->close();
?>
