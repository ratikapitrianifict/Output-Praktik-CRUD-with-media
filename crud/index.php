<?php
/**
 * Halaman Daftar CRUD Mahasiswa (crud/index.php)
 * Modul 08 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

$sql = "SELECT id, nim, nama, program_studi, email
        FROM mahasiswa
        ORDER BY id DESC";
$result = $conn->query($sql);
$status = $_GET["status"] ?? "";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mahasiswa - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>CRUD Mahasiswa</h1>
        <p>Web Programming 1 - Pengelolaan Data Mahasiswa (Modul 08)</p>
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
            <div class="section-header">
                <div>
                    <h2>Daftar Data Mahasiswa</h2>
                    <p class="text-muted" style="margin: 4px 0 0 0;">Pengelolaan data akademik mahasiswa dengan fitur pencarian langsung, pembaruan, dan penghapusan data.</p>
                </div>
            </div>

            <?php if ($status === "tambah"): ?>
                <div class="message sukses">Data mahasiswa berhasil ditambahkan ke dalam database.</div>
            <?php elseif ($status === "update"): ?>
                <div class="message sukses">Data mahasiswa berhasil diperbarui.</div>
            <?php elseif ($status === "hapus"): ?>
                <div class="message sukses">Data mahasiswa berhasil dihapus dari database.</div>
            <?php endif; ?>

            <div class="crud-toolbar">
                <a class="btn" href="tambah.php">Tambah Data Mahasiswa</a>
                <input type="search" id="searchMahasiswa" placeholder="Cari NIM, nama, program studi, atau email...">
            </div>

            <div class="table-scroll">
                <table class="data-table" id="crudTable">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th class="col-nim">NIM</th>
                            <th class="col-nama">Nama Lengkap</th>
                            <th class="col-prodi">Program Studi</th>
                            <th class="col-email">Email</th>
                            <th class="col-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr data-search="<?= htmlspecialchars(strtolower($row["nim"] . " " . $row["nama"] . " " . $row["program_studi"] . " " . $row["email"])); ?>">
                                    <td class="col-no"><?= $no++; ?></td>
                                    <td class="col-nim"><?= htmlspecialchars($row["nim"]); ?></td>
                                    <td class="col-nama"><?= htmlspecialchars($row["nama"]); ?></td>
                                    <td class="col-prodi"><?= htmlspecialchars($row["program_studi"]); ?></td>
                                    <td class="col-email"><?= htmlspecialchars($row["email"]); ?></td>
                                    <td class="actions col-action">
                                        <div class="action-group">
                                            <a href="edit.php?id=<?= (int) $row["id"]; ?>" class="btn-edit">Edit</a>
                                            <form action="../proses/proses_hapus.php" method="POST" class="delete-form">
                                                <input type="hidden" name="id" value="<?= (int) $row["id"]; ?>">
                                                <button type="submit" class="btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr data-empty-row="true">
                                <td colspan="6" class="empty-table-cell">
                                    Belum ada data mahasiswa. Silakan memilih tombol <strong>Tambah Data Mahasiswa</strong> untuk menambahkan data baru.
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

    <script src="../assets/js/crud.js"></script>
</body>
</html>
<?php
$conn->close();
?>
