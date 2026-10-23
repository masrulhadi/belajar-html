CREATE DATABASE IF NOT EXISTS db_belajar_php
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE db_belajar_php;

-- Tabel Users
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

-- Tabel Learning Goals
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