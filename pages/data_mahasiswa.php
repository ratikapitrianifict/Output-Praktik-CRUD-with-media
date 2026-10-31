<?php
/**
 * Halaman Data Mahasiswa Terintegrasi Database (pages/data_mahasiswa.php)
 * Modul 3B, 4B, 5B & Modul 08 - Web Programming 1
 */

require_once "../config/auth.php";
require_once "../config/koneksi.php";

$sql = "SELECT id, nim, nama, program_studi, email FROM mahasiswa ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>Data Mahasiswa</h1>
        <p>Web Programming 1 - Integrasi Database MySQL &amp; Dynamic Table</p>
    </header>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php">Biodata</a>
        <a href="layout.php">Layout Lab</a>
        <a href="data_mahasiswa.php" class="active">Data Mahasiswa</a>
        <a href="form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../crud/index.php">CRUD Mahasiswa</a>
        <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
    </nav>

    <main>
        <section class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px;">
                <h2 style="margin: 0;">Daftar Mahasiswa Terdaftar (Tampilan Modul Lama)</h2>
                <div style="display: flex; gap: 8px;">
                    <a href="form_mahasiswa.php" class="btn-action" style="background-color: #1f4e79; color: white;">+ Tambah Mahasiswa Baru</a>
                    <a href="../crud/index.php" class="btn-action" style="background-color: #10b981; color: white;">Buka Fitur CRUD &raquo;</a>
                </div>
            </div>

            <?php if (isset($_GET["status"]) && $_GET["status"] === "sukses"): ?>
                <div class="message sukses" style="margin-top: 16px;">
                    &check; Data mahasiswa berhasil disimpan ke database.
                </div>
            <?php endif; ?>

            <table class="data-table">
                <caption>Data Mahasiswa dari MySQL (Database: web_programming_1)</caption>
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px; text-align: center;">No</th>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Program Studi</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td style="text-align: center;"><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row["nim"]); ?></td>
                                <td><?= htmlspecialchars($row["nama"]); ?></td>
                                <td><?= htmlspecialchars($row["program_studi"]); ?></td>
                                <td><?= htmlspecialchars($row["email"]); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #64748b; padding: 24px;">
                                Belum ada data mahasiswa di tabel <code>mahasiswa</code>. Silakan <a href="form_mahasiswa.php">tambah data baru</a>.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>Copyright &copy; 2026 - Web Programming 1</p>
    </footer>

</body>
</html>
<?php
$conn->close();
?>
