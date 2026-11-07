<?php
/**
 * Halaman Data Mahasiswa Terintegrasi Database (pages/data_mahasiswa.php)
 * Modul 3B, 4B, 5B & Modul 08 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

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
        <p>Web Programming 1 - Integrasi Database MySQL dan Tabel Dinamis</p>
    </header>

    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="index.php">Biodata</a>
        <a href="layout.php">Layout Lab</a>
        <a href="data_mahasiswa.php" class="active">Data Mahasiswa</a>
        <a href="form_mahasiswa.php">Tambah Mahasiswa</a>
        <a href="../crud/index.php">CRUD Mahasiswa</a>
        <a href="../crud-media/index.php">CRUD Media</a>
        <a href="../proses/logout.php" class="nav-logout">Logout (<?= htmlspecialchars($_SESSION["username"]); ?>)</a>
    </nav>

    <main>
        <section class="card">
            <div class="section-header">
                <div>
                    <h2>Daftar Mahasiswa Terdaftar</h2>
                    <p class="text-muted" style="margin: 4px 0 0 0;">Data mahasiswa yang tersimpan pada tabel <code>mahasiswa</code> di database <code>web_programming_1</code>.</p>
                </div>
                <div class="link-group" style="margin-top: 0;">
                    <a href="form_mahasiswa.php" class="btn-action btn-primary">Tambah Mahasiswa Baru</a>
                    <a href="../crud/index.php" class="btn-action btn-secondary">Buka Modul CRUD</a>
                </div>
            </div>

            <?php if (isset($_GET["status"]) && $_GET["status"] === "sukses"): ?>
                <div class="message sukses">
                    Data mahasiswa berhasil disimpan ke dalam database.
                </div>
            <?php endif; ?>

            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th scope="col" class="col-no">No</th>
                            <th scope="col" class="col-nim">NIM</th>
                            <th scope="col" class="col-nama">Nama Lengkap</th>
                            <th scope="col" class="col-prodi">Program Studi</th>
                            <th scope="col" class="col-email">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="col-no"><?= $no++; ?></td>
                                    <td class="col-nim"><?= htmlspecialchars($row["nim"]); ?></td>
                                    <td class="col-nama"><?= htmlspecialchars($row["nama"]); ?></td>
                                    <td class="col-prodi"><?= htmlspecialchars($row["program_studi"]); ?></td>
                                    <td class="col-email"><?= htmlspecialchars($row["email"]); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="empty-table-cell">
                                    Belum ada data mahasiswa pada tabel <code>mahasiswa</code>. Silakan <a href="form_mahasiswa.php" class="text-link">menambahkan data baru</a>.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
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
