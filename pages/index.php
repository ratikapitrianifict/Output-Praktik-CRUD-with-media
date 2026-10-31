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
    <title>Biodata Saya - Ratika Pitriani</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <!-- HEADER -->
    <header>
        <h1>BIODATA SAYA</h1>
        <p>Website Biodata Sederhana &bull; Web Programming 1</p>
    </header>

    <!-- NAVIGATION (Modul 08) -->
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php" class="active">Biodata</a>
        <a href="layout.php">Layout Lab</a>
        <a href="data_mahasiswa.php">Data Mahasiswa</a>
        <a href="form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../crud/index.php">CRUD Mahasiswa</a>
        <?php if ($is_logged_in): ?>
            <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
        <?php else: ?>
            <a href="login.php" style="background-color: #1f4e79; color: white;">Login System &raquo;</a>
        <?php endif; ?>
    </nav>

    <!-- MAIN CONTENT -->
    <main>
        <!-- BIODATA PRIBADI -->
        <section id="biodata" class="card">
            <h2>Data Pribadi</h2>
            <div style="display: flex; gap: 24px; flex-wrap: wrap; align-items: flex-start;">
                <div style="text-align: center; margin: 0 auto;">
                    <img src="../assets/images/foto.jpg" onerror="this.onerror=null;this.src='../assets/images/profile.jpg';" alt="Foto Profil Ratika Pitriani" class="profile-photo">
                </div>
                <div style="flex: 1; min-width: 280px;">
                    <table class="data-table" style="margin-top: 0;">
                        <tbody>
                            <tr>
                                <th scope="row" style="width: 32%;">Nama</th>
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
                                <td>FICT</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td><a href="mailto:student@horizon.ac.id" style="color: #1f4e79; text-decoration: none; font-weight: 500;">student@horizon.ac.id</a></td>
                            </tr>
                            <tr>
                                <th scope="row">Tempat Lahir</th>
                                <td>Indonesia</td>
                            </tr>
                            <tr>
                                <th scope="row">Tanggal Lahir</th>
                                <td>[Disamarkan demi privasi]</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- TENTANG SAYA -->
        <section id="tentang" class="card">
            <h2>Tentang Saya</h2>
            <p>
                Halo, nama saya <strong>Ratika Pitriani</strong>. Saya merupakan mahasiswa Program Studi Informatika di Fakultas Ilmu Komputer dan Teknologi Informasi (FICT). Saya sangat tertarik mempelajari teknologi, pemrograman, pengembangan aplikasi, dan Web Development.
            </p>
            <p>
                Saat ini saya sedang mempelajari pengembangan website modern menggunakan HTML, CSS Box Model, PHP Backend, integrasi database MySQL, sistem Autentikasi / Session Guard, dan Operasi CRUD (Create, Read, Update, Delete).
            </p>
        </section>

        <!-- RIWAYAT PENDIDIKAN -->
        <section id="pendidikan" class="card">
            <h2>Riwayat Pendidikan</h2>
            <ol style="padding-left: 20px; line-height: 1.8;">
                <li>Sekolah Dasar (SD)</li>
                <li>Sekolah Menengah Pertama (SMP / MTs)</li>
                <li>Sekolah Menengah Kejuruan (SMK / SMA)</li>
                <li>S1 Informatika - Universitas Horizon Indonesia (FICT)</li>
            </ol>
        </section>

        <!-- HOBI -->
        <section id="hobi" class="card">
            <h2>Hobi &amp; Minat</h2>
            <ul class="badge-list">
                <li>Badminton</li>
                <li>Mendengarkan Musik</li>
                <li>Coding</li>
                <li>Membaca</li>
                <li>Traveling</li>
            </ul>
        </section>

        <!-- SKILL -->
        <section id="skill" class="card">
            <h2>Skill &amp; Keahlian</h2>
            <ul class="badge-list skill-list">
                <li>HTML5</li>
                <li>CSS3 Box Model</li>
                <li>JavaScript DOM &amp; Validation</li>
                <li>PHP &amp; MySQL Prepared Statements</li>
                <li>Python</li>
                <li>UI/UX Design</li>
            </ul>
        </section>

        <!-- SOSIAL MEDIA -->
        <section id="sosial-media" class="card">
            <h2>Social Media</h2>
            <div class="social-links">
                <p>
                    <strong>Instagram:</strong>
                    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer">
                        Instagram Saya &raquo;
                    </a>
                </p>
                <p>
                    <strong>LinkedIn:</strong>
                    <a href="https://www.linkedin.com/" target="_blank" rel="noopener noreferrer">
                        LinkedIn &raquo;
                    </a>
                </p>
                <p>
                    <strong>GitHub:</strong>
                    <a href="https://github.com/ratikapitrianifict" target="_blank" rel="noopener noreferrer">
                        GitHub Profile &raquo;
                    </a>
                </p>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer>
        <p>Copyright &copy; 2026 - Ratika Pitriani &bull; Web Programming 1</p>
    </footer>
</body>
</html>
