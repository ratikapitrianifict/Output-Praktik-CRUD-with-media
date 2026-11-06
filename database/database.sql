-- =========================================================
-- DATABASE BACKUP: web_programming_1
-- Modul 08 & Modul 10 - Web Programming 1
-- Backup skema tabel users & mahasiswa (dengan kolom media)
-- =========================================================
CREATE DATABASE IF NOT EXISTS `web_programming_1` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_programming_1`;
-- --------------------------------------------------------
-- Struktur Tabel `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `nama_lengkap` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- --------------------------------------------------------
-- Data Awal untuk Tabel `users` (Password default: 123)
-- --------------------------------------------------------
INSERT INTO `users` (
    `id`,
    `username`,
    `password_hash`,
    `nama_lengkap`,
    `created_at`
  )
VALUES (
    1,
    'admin',
    '$2y$10$w8k2rZ0/7nJc0uN7T4ZkEu7Z0/7nJc0uN7T4ZkEu7Z0/7nJc0uN7T',
    'Administrator Lab',
    NOW()
  ) (
    1,
    'admin',
    '$2y$10$wUFbHKlqn0BNAmVqje2TB.N08A9eYd4NgwQ4VbKZci/niNfjfHY8i',
    'Administrator Lab',
    NOW()
  ) ON DUPLICATE KEY
UPDATE `username` =
VALUES(`username`);
-- --------------------------------------------------------
-- Struktur Tabel `mahasiswa` (Modul 08 + Upgrade Modul 10)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nim` VARCHAR(20) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `program_studi` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `foto` VARCHAR(255) NULL,
  `audio` VARCHAR(255) NULL,
  `dokumen` VARCHAR(255) NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;
-- --------------------------------------------------------
-- Query Upgrade untuk Tabel `mahasiswa` Lama (Step 3 Modul 10)
-- Jalankan query berikut jika tabel mahasiswa sudah ada dari sesi sebelumnya:
--
-- ALTER TABLE mahasiswa
-- ADD foto VARCHAR(255) NULL,
-- ADD audio VARCHAR(255) NULL,
-- ADD dokumen VARCHAR(255) NULL;
-- --------------------------------------------------------
-- --------------------------------------------------------
-- Data Latihan untuk Tabel `mahasiswa`
-- --------------------------------------------------------
INSERT INTO `mahasiswa` (
    `id`,
    `nim`,
    `nama`,
    `program_studi`,
    `email`,
    `foto`,
    `audio`,
    `dokumen`
  )
VALUES (
    1,
    '230001',
    'Andi Pratama',
    'Informatika',
    'andi@email.com',
    NULL,
    NULL,
    NULL
  ),
  (
    2,
    '230002',
    'Budi Santoso',
    'Sistem Informasi',
    'budi@email.com',
    NULL,
    NULL,
    NULL
  ),
  (
    3,
    '230003',
    'Citra Lestari',
    'Informatika',
    'citra@email.com',
    NULL,
    NULL,
    NULL
  ),
  (
    4,
    '230004',
    'Dewi Anggraini',
    'Teknologi Informasi',
    'dewi@email.com',
    NULL,
    NULL,
    NULL
  ) ON DUPLICATE KEY
UPDATE `nim` =
VALUES(`nim`);