<?php
/**
 * Halaman Biodata Publik (pages/index.php)
 * Modul 1A, 2A, 3B, 4A, 5B & Modul 08 - Web Programming 1
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$is_logged_in = isset($_SESSION["user_id"]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata Mahasiswa - Ratika Pitriani</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Biodata Mahasiswa</h1>
        <p>Profil Akademik Mahasiswa - Web Programming 1</p>
    </header>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php" class="active">Biodata</a>
        <a href="layout.php">Layout Lab</a>
        <a href="data_mahasiswa.php">Data Mahasiswa</a>
        <a href="form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../crud/index.php">CRUD Mahasiswa</a>
        <a href="../crud-media/index.php">CRUD Media</a>
        <?php if ($is_logged_in): ?>
            <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
        <?php else: ?>
            <a href="login.php" class="nav-login">Login</a>
        <?php endif; ?>
    </nav>

    <main>
        <section id="biodata" class="card">
            <h2>Data Pribadi</h2>
            <div class="biodata-layout">
                <div class="biodata-photo-wrap">
                    <img
                        src="../assets/images/foto.jpg"
                        onerror="this.onerror=null;this.src='../assets/images/profile.jpg';"
                        alt="Foto Profil Ratika Pitriani"
                        class="profile-photo"
                    >
                </div>
                <div class="biodata-info">
                    <table class="data-table">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 32%;">Nama Lengkap</th>
                                <td>Ratika Pitriani</td>
                            </tr>
                            <tr>
                                <th scope="row">NIM</th>
                                <td>411275520125xxxx</td>
                            </tr>
                            <tr>
                                <th scope="row">Program Studi</th>
                                <td>Informatika</td>
                            </tr>
                            <tr>
                                <th scope="row">Fakultas</th>
                                <td>Fakultas Ilmu Komputer dan Teknologi Informasi (FICT)</td>
                            </tr>
                            <tr>
                                <th scope="row">Email Akademik</th>
                                <td><a href="mailto:student@horizon.ac.id" class="text-link">student@horizon.ac.id</a></td>
                            </tr>
                            <tr>
                                <th scope="row">Tempat Lahir</th>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal Lahir</th>
                                <td>Disamarkan untuk privasi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="tentang" class="card">
            <h2>Deskripsi Singkat</h2>
            <p>
                Saya <strong>Ratika Pitriani</strong>, mahasiswa Program Studi Informatika pada Fakultas Ilmu Komputer dan Teknologi Informasi (FICT). Saya memiliki minat dalam bidang rekayasa perangkat lunak, pemrograman berorientasi web, serta pengelolaan sistem basis data.
            </p>
            <p>
                Proyek ini dikembangkan sebagai bagian dari rangkaian praktikum mata kuliah Web Programming 1 yang menerapkan struktur semantik HTML5, penataan tampilan berbasis CSS Box Model, pemrosesan backend PHP, integrasi database MySQL dengan Prepared Statements, autentikasi berbasis sesi, serta pengelolaan data dan file multimedia (CRUD Media).
            </p>
        </section>

        <section id="pendidikan" class="card">
            <h2>Riwayat Pendidikan</h2>
            <ol class="education-list">
                <li>Sekolah Dasar (SD)</li>
                <li>Sekolah Menengah Pertama (SMP / MTs)</li>
                <li>Sekolah Menengah Atas / Kejuruan (SMA / SMK)</li>
                <li>S1 Informatika - Universitas Horizon Indonesia (FICT)</li>
            </ol>
        </section>

        <section id="hobi" class="card">
            <h2>Minat dan Aktivitas</h2>
            <ul class="badge-list">
                <li>Bulu Tangkis</li>
                <li>Pemrograman Web</li>
                <li>Literasi Teknologi</li>
                <li>Musik</li>
                <li>Perjalanan</li>
            </ul>
        </section>

        <section id="skill" class="card">
            <h2>Kompetensi Teknis</h2>
            <ul class="badge-list skill-list">
                <li>HTML5 Semantik</li>
                <li>CSS3 Box Model &amp; Layout</li>
                <li>JavaScript DOM &amp; Validasi Form</li>
                <li>PHP &amp; MySQLi Prepared Statements</li>
                <li>Python Dasar</li>
                <li>Perancangan Antarmuka (UI/UX)</li>
            </ul>
        </section>

        <section id="sosial-media" class="card">
            <h2>Tautan Eksternal</h2>
            <div class="social-links">
                <p>
                    <strong>Instagram:</strong>
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">Kunjungi Profil Instagram</a>
                </p>
                <p>
                    <strong>LinkedIn:</strong>
                    <a href="https://www.linkedin.com/" target="_blank" rel="noopener noreferrer">Kunjungi Profil LinkedIn</a>
                </p>
                <p>
                    <strong>GitHub:</strong>
                    <a href="https://github.com/ratikapitrianifict" target="_blank" rel="noopener noreferrer">github.com/ratikapitrianifict</a>
                </p>
            </div>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 - Ratika Pitriani - Web Programming 1</p>
    </footer>

</body>
</html>
