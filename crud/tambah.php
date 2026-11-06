<?php
/**
 * Halaman Tambah Data CRUD Mahasiswa (crud/tambah.php)
 * Modul 08 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data CRUD - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Tambah Data Mahasiswa</h1>
        <p>Formulir Input Data Mahasiswa dengan Validasi Client-Side dan Server-Side (Modul 08)</p>
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
                <h2>Formulir Tambah Mahasiswa</h2>
                <p>Lengkapi seluruh data di bawah ini sesuai dengan format yang ditentukan.</p>
            </div>

            <form
                class="crud-form"
                data-crud-form
                action="../proses/proses_crud_tambah.php"
                method="POST"
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

                <div class="form-actions">
                    <button type="submit">Simpan Data</button>
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
