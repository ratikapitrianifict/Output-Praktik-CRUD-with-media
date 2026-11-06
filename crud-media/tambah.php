<?php
/**
 * Halaman Tambah Data CRUD Media (crud-media/tambah.php)
 * Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah CRUD Media - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Tambah Data Media</h1>
        <p>Unggah File PHP, Validasi Server, dan Pratinjau DOM JavaScript (Modul 10)</p>
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
                <h2>Formulir Tambah Mahasiswa dan Media</h2>
                <p>Lengkapi data akademik mahasiswa serta unggah foto profil (wajib), file audio (opsional), dan dokumen PDF (opsional).</p>
            </div>

            <form
                class="crud-form"
                data-media-form
                data-require-foto="true"
                action="../proses/crud-media/tambah.php"
                method="POST"
                enctype="multipart/form-data"
                novalidate
            >
                <label for="nim">NIM</label>
                <input id="nim" name="nim" type="text" placeholder="Contoh: 230005" required>
                <small class="form-error" id="errorNim"></small>

                <label for="nama">Nama Lengkap</label>
                <input id="nama" name="nama" type="text" placeholder="Contoh: Andi Pratama" required>
                <small class="form-error" id="errorNama"></small>

                <label for="program_studi">Program Studi</label>
                <input id="program_studi" name="program_studi" type="text" placeholder="Contoh: Informatika" required>
                <small class="form-error" id="errorProdi"></small>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Contoh: andi@email.com" required>
                <small class="form-error" id="errorEmail"></small>

                <label for="foto">Foto (Wajib, JPG/PNG/WEBP, Maksimal 2 MB)</label>
                <input
                    id="foto"
                    name="foto"
                    type="file"
                    accept="image/jpeg,image/png,image/webp"
                    required
                >
                <small class="form-error" id="errorFoto"></small>

                <div class="media-preview-box">
                    <strong>Pratinjau Foto</strong>
                    <span class="file-hint" id="emptyPreviewFoto">Belum ada foto dipilih.</span>
                    <img
                        id="previewFoto"
                        class="media-preview-image"
                        alt="Pratinjau foto"
                        hidden
                    >
                </div>

                <label for="audio">Audio (Opsional, MP3/WAV, Maksimal 2 MB)</label>
                <input
                    id="audio"
                    name="audio"
                    type="file"
                    accept="audio/mpeg,audio/wav,.mp3,.wav"
                >
                <small class="form-error" id="errorAudio"></small>

                <div class="media-preview-box">
                    <strong>Pratinjau Audio</strong>
                    <span class="file-hint" id="emptyPreviewAudio">Belum ada audio dipilih.</span>
                    <audio
                        id="previewAudio"
                        class="media-preview-audio"
                        controls
                        hidden
                    ></audio>
                </div>

                <label for="dokumen">Dokumen (Opsional, PDF, Maksimal 2 MB)</label>
                <input
                    id="dokumen"
                    name="dokumen"
                    type="file"
                    accept="application/pdf,.pdf"
                >
                <small class="form-error" id="errorDokumen"></small>

                <div class="media-preview-box">
                    <strong>Informasi Dokumen</strong>
                    <p id="previewDokumen" class="file-hint" style="margin: 4px 0 0 0;">Belum ada dokumen dipilih.</p>
                </div>

                <div class="form-actions">
                    <button type="submit">Simpan Data Media</button>
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
