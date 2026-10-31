-- =========================================================
-- DATABASE BACKUP: web_programming_1
-- Modul 08 - Web Programming 1
-- Backup sebelum latihan DELETE & CRUD
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data Awal untuk Tabel `users` (Password default: 123)
-- --------------------------------------------------------
INSERT INTO `users` (`id`, `username`, `password_hash`, `nama_lengkap`, `created_at`) VALUES
(1, 'admin', '$2y$10$w8k2rZ0/7nJc0uN7T4ZkEu7Z0/7nJc0uN7T4ZkEu7Z0/7nJc0uN7T', 'Administrator Lab', NOW())
ON DUPLICATE KEY UPDATE `username` = VALUES(`username`);

-- --------------------------------------------------------
-- Struktur Tabel `mahasiswa`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nim` VARCHAR(20) NOT NULL,
  `nama` VARCHAR(100) NOT NULL,
  `program_studi` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Data Latihan untuk Tabel `mahasiswa`
-- --------------------------------------------------------
INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `program_studi`, `email`) VALUES
(1, '230001', 'Andi Pratama', 'Informatika', 'andi@email.com'),
(2, '230002', 'Budi Santoso', 'Sistem Informasi', 'budi@email.com'),
(3, '230003', 'Citra Lestari', 'Informatika', 'citra@email.com'),
(4, '230004', 'Dewi Anggraini', 'Teknologi Informasi', 'dewi@email.com')
ON DUPLICATE KEY UPDATE `nim` = VALUES(`nim`);
