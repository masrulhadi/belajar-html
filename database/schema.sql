-- ============================================================
-- Skrip Inisialisasi Database: db_belajar_php
-- Tugas Pemrograman Web: Belajar HTML & CRUD PHP (Zero JS)
-- ============================================================

CREATE DATABASE IF NOT EXISTS db_belajar_php
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_belajar_php;

-- ------------------------------------------------------------
-- 1. Tabel Users (Data Akun & Profil Pengguna)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio TEXT NULL,
    telepon VARCHAR(20) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 2. Tabel Learning Goals (Target & Progres Belajar - Fitur CRUD)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS learning_goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judul VARCHAR(150) NOT NULL,
    kategori ENUM('HTML', 'CSS', 'PHP', 'Database', 'Lainnya') DEFAULT 'HTML',
    status ENUM('Belum Dimulai', 'Sedang Belajar', 'Selesai') DEFAULT 'Belum Dimulai',
    catatan TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_goals 
      FOREIGN KEY (user_id) 
      REFERENCES users(id) 
      ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 3. Data Awal (Sample Data untuk Pengujian & Demo Dosen)
-- ------------------------------------------------------------
-- Password default akun demo: "admin123"
-- Dihasilkan menggunakan PHP password_hash("admin123", PASSWORD_BCRYPT)
INSERT INTO users (id, nama, email, password, bio, telepon) VALUES 
(1, 'Masrul Hadi', 'masrul@example.com', '$2y$12$/S7uwSh/ARGWqNccdHm7yevdKg8z3.h4oQ2xn.E.MUaaLogq56w/O', 'Mahasiswa Teknik Informatika yang antusias mempelajari pemrograman web fundamental.', '081234567890')
ON DUPLICATE KEY UPDATE id=id;

INSERT INTO learning_goals (user_id, judul, kategori, status, catatan) VALUES
(1, 'Memahami Struktur Dokumen HTML5 & Semantik', 'HTML', 'Selesai', 'Mempelajari penggunaan header, nav, main, section, dan footer tanpa JS.'),
(1, 'Responsive Web Design dengan Flexbox & Grid', 'CSS', 'Selesai', 'Menerapkan layout responsif di seluruh halaman katalog dan kartu profil.'),
(1, 'Integrasi CRUD PHP & MySQL dengan PDO', 'PHP', 'Sedang Belajar', 'Implementasi sistem autentikasi, manajemen profil, dan target belajar berbasis session.'),
(1, 'Konfigurasi Container Docker (PHP + MySQL)', 'Database', 'Selesai', 'Memastikan environment aplikasi dapat direproduksi dengan satu perintah docker compose.');
