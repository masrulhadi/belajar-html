# Belajar HTML & CRUD PHP

- **Nama:** Masrul Hadi
- **NIM:** 240705068
- **Mata Kuliah:** Pemrograman Web

---

## 📌 Deskripsi Proyek
Proyek ini merupakan aplikasi web bertema platform pembelajaran teknologi yang dibangun menggunakan **HTML5, CSS3, PHP, dan MySQL**.

Aplikasi ini mengintegrasikan alur autentikasi dan fitur **CRUD lengkap (Create, Read, Update, Delete)** di halaman profil pengguna dengan pola **Post/Redirect/Get (PRG)** serta keamanan berbasis **PDO Prepared Statements** dan **BCRYPT Password Hashing**.

---

## 🚀 Cara Menjalankan dengan Docker

Pastikan Docker & Docker Compose sudah terpasang di komputer Anda.

1. **Siapkan konfigurasi environment:**
   ```bash
   cp .env.example .env
   ```
   Lalu edit `.env` dan isi `DB_ROOT_PASSWORD` dengan password MySQL yang Anda inginkan.

2. **Jalankan Container:**
   ```bash
   docker compose up -d
   ```
3. **Akses Aplikasi:**
   - **Website Utama:** [http://localhost:8090](http://localhost:8090)
   - **phpMyAdmin (Inspeksi Database):** [http://localhost:8080](http://localhost:8080)
     - *Server:* `db`
     - *Username:* `root`
     - *Password:* sesuai `DB_ROOT_PASSWORD` di `.env`

4. **Menghentikan Container:**
   ```bash
   docker compose down
   ```

---

## 🔑 Akun Demo Dosen / Penguji

Database sudah otomatis diinisialisasi melalui berkas [`database/schema.sql`](database/schema.sql) dengan data awal:
- **Email:** `masrul@example.com`
- **Kata Sandi:** `admin123`

---

## 🛠️ Arsitektur Fitur CRUD & Alur Sistem

1. **Registrasi (`pages/auth/register.php`):**
   - Mendaftarkan pengguna baru dengan validasi server-side.
   - Kata sandi dienkripsi menggunakan `password_hash($pass, PASSWORD_BCRYPT)`.
2. **Masuk / Login (`pages/auth/login.php`):**
   - Memverifikasi akun menggunakan `password_verify()`.
   - Menginisialisasi session pengguna dan mengarahkan ke dashboard profil.
3. **Dashboard Profil & Read Data (`pages/profile/index.php`):**
   - **Read User:** Menampilkan profil akun, nama, email, nomor kontak, dan biodata.
   - **Read Target:** Menampilkan tabel daftar target pembelajaran milik pengguna aktif.
4. **Create Target Belajar (`pages/goals/add.php`):**
   - Formulir penambahan materi atau target belajar baru ke tabel `learning_goals`.
5. **Update Profil & Target (`pages/profile/edit.php` & `pages/goals/edit.php`):**
   - Mengubah biodata profil dan rincian status target pembelajaran.
6. **Delete Target & Akun (`pages/goals/delete.php` & `pages/profile/delete.php`):**
   - Konfirmasi penghapusan data via metode HTTP POST yang aman (tanpa JS alert/confirm).
   - Relasi Foreign Key `ON DELETE CASCADE` memastikan data terhapus secara bersih jika akun dihapus.
7. **Keluar / Logout (`pages/auth/logout.php`):**
   - Menghancurkan session dan menghapus cookie autentikasi.

---

## 🗄️ Struktur Database (`database/schema.sql`)
1. **Tabel `users`**: Menyimpan identitas akun, email unik, password hash, bio, dan nomor telepon.
2. **Tabel `learning_goals`**: Menyimpan target belajar per pengguna dengan relasi foreign key `user_id` ke tabel `users`.