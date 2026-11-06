<?php
/**
 * Halaman Daftar CRUD Media (crud-media/index.php)
 * Modul 10 - Web Programming 1
 */

require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/koneksi.php";

$sql = "SELECT id, nim, nama, program_studi, email, foto, audio, dokumen
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
    <title>CRUD Media - Web Programming 1</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

    <header>
        <h1>CRUD Media</h1>
        <p>Web Programming 1 - Multimedia CRUD dan Pengelolaan File (Modul 10)</p>
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
            <?php if ($status === "tambah"): ?>
                <div class="message sukses">Data mahasiswa beserta file media berhasil ditambahkan.</div>
            <?php elseif ($status === "update"): ?>
                <div class="message sukses">Data mahasiswa dan file media berhasil diperbarui.</div>
            <?php elseif ($status === "hapus"): ?>
                <div class="message sukses">Data mahasiswa beserta file media terkait berhasil dihapus.</div>
            <?php endif; ?>

            <div class="crud-toolbar">
                <a class="btn" href="tambah.php">Tambah Data Media</a>
                <input
                    type="search"
                    id="searchMedia"
                    placeholder="Cari NIM, nama, program studi, atau email..."
                >
            </div>

            <div class="table-scroll">
                <table class="data-table" id="mediaTable">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th class="col-photo">Foto</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Program Studi</th>
                            <th>Email</th>
                            <th>Audio</th>
                            <th class="col-center">Dokumen</th>
                            <th class="col-action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php $no = 1; ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="col-no"><?= $no++; ?></td>
                                    <td class="col-photo">
                                        <?php if (!empty($row["foto"])): ?>
                                            <img
                                                class="table-photo"
                                                src="../uploads/images/<?= htmlspecialchars($row["foto"]); ?>"
                                                alt="Foto <?= htmlspecialchars($row["nama"]); ?>"
                                            >
                                        <?php else: ?>
                                            <span class="media-empty-badge">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row["nim"]); ?></td>
                                    <td><?= htmlspecialchars($row["nama"]); ?></td>
                                    <td><?= htmlspecialchars($row["program_studi"]); ?></td>
                                    <td><?= htmlspecialchars($row["email"]); ?></td>
                                    <td>
                                        <?php if (!empty($row["audio"])): ?>
                                            <audio controls preload="none" class="table-audio">
                                                <source src="../uploads/audio/<?= htmlspecialchars($row["audio"]); ?>">
                                            </audio>
                                        <?php else: ?>
                                            <span class="media-empty-badge">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="col-center">
                                        <?php if (!empty($row["dokumen"])): ?>
                                            <a
                                                class="pdf-link"
                                                href="../uploads/documents/<?= htmlspecialchars($row["dokumen"]); ?>"
                                                target="_blank"
                                                rel="noopener"
                                            >
                                                Buka PDF
                                            </a>
                                        <?php else: ?>
                                            <span class="media-empty-badge">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="actions">
                                        <a href="edit.php?id=<?= (int) $row["id"]; ?>">Edit</a>
                                        <form
                                            action="../proses/crud-media/hapus.php"
                                            method="POST"
                                            class="media-delete-form"
                                        >
                                            <input
                                                type="hidden"
                                                name="id"
                                                value="<?= (int) $row["id"]; ?>"
                                            >
                                            <button type="submit" class="btn-delete">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr data-empty-row="true">
                                <td colspan="9" class="empty-table-cell">
                                    Belum ada data mahasiswa. Silakan memilih tombol <strong>Tambah Data Media</strong> untuk menambahkan data baru.
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

    <script src="../assets/js/media.js"></script>
</body>
</html>
<?php
$conn->close();
?>
