<?php
/**
 * Halaman Form Tambah Mahasiswa (pages/form_mahasiswa.php)
 * Modul 4B, 5B & Modul 08 - Web Programming 1
 * Catatan Modul 08: Halaman Tambah Mahasiswa lama TETAP, tidak diubah konten utamanya.
 */

require_once "../config/auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Tambah Mahasiswa</h1>
        <p>Web Programming 1 - Formulir Input Data Baru (Modul 4B)</p>
    </header>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php">Biodata</a>
        <a href="layout.php">Layout Lab</a>
        <a href="data_mahasiswa.php">Data Mahasiswa</a>
        <a href="form_mahasiswa.php" class="active">Tambah Mahasiswa</a>
        <a href="../crud/index.php">CRUD Mahasiswa</a>
        <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
    </nav>

    <main>
        <section class="card">
            <h2>Form Data Mahasiswa</h2>
            <p style="color: #64748b; margin-top: -6px; margin-bottom: 20px;">
                Isi seluruh formulir berikut untuk menambahkan data ke database MySQL <code>web_programming_1</code>.
            </p>

            <form action="../proses/proses_tambah.php" method="POST" class="student-form">
                <label for="nim">NIM</label>
                <input id="nim" name="nim" type="text" placeholder="Contoh: 230005" required>

                <label for="nama">Nama Lengkap</label>
                <input id="nama" name="nama" type="text" placeholder="Contoh: Muhammad Rizki" required>

                <label for="program_studi">Program Studi</label>
                <input id="program_studi" name="program_studi" type="text" placeholder="Contoh: Informatika / Sistem Informasi" required>

                <label for="email">Email</label>
                <input id="email" name="email" type="email" placeholder="Contoh: rizki@email.com" required>

                <div style="display: flex; gap: 10px; margin-top: 10px;">
                    <button type="submit" style="background-color: #1f4e79; color: white;">Simpan Data</button>
                    <a href="data_mahasiswa.php" class="btn-action" style="background-color: #e2e8f0; color: #334155; text-decoration: none;">Batal</a>
                </div>
            </form>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 - Web Programming 1</p>
    </footer>

</body>
</html>
