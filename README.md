# Belajar HTML & CRUD PHP (Zero JS)

- **Nama:** Masrul Hadi
- **NIM:** 240705068
- **Mata Kuliah:** Pemrograman Web

---

## 📌 Deskripsi Proyek
Proyek ini merupakan aplikasi web bertema platform pembelajaran teknologi yang dibangun secara murni menggunakan **HTML5, CSS3, PHP, dan MySQL tanpa JavaScript (Zero JS)**.

Aplikasi ini mengintegrasikan alur autentikasi dan fitur **CRUD lengkap (Create, Read, Update, Delete)** di halaman profil pengguna dengan pola **Post/Redirect/Get (PRG)** serta keamanan berbasis **PDO Prepared Statements** dan **BCRYPT Password Hashing**.

---

## 🚀 Cara Menjalankan dengan Docker

Pastikan Docker & Docker Compose sudah terpasang di komputer Anda.

1. **Jalankan Container:**
   ```bash
   docker compose up -d
   ```
2. **Akses Aplikasi:**
   - **Website Utama:** [http://localhost:8090](http://localhost:8090)
   - **phpMyAdmin (Inspeksi Database):** [http://localhost:8080](http://localhost:8080)
     - *Server:* `db`
     - *Username:* `root`
     - *Password:* `rahasia123`

3. **Menghentikan Container:**
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
3. **Dashboard Profil & Read Data (`pages/profile.php`):**
   - **Read User:** Menampilkan profil akun, nama, email, nomor kontak, dan biodata.
   - **Read Target:** Menampilkan tabel daftar target pembelajaran milik pengguna aktif.
4. **Create Target Belajar (`pages/goal-add.php`):**
   - Formulir penambahan materi atau target belajar baru ke tabel `learning_goals`.
5. **Update Profil & Target (`pages/profile-edit.php` & `pages/goal-edit.php`):**
   - Mengubah biodata profil dan rincian status target pembelajaran.
6. **Delete Target & Akun (`pages/goal-delete.php` & `pages/account-delete.php`):**
   - Konfirmasi penghapusan data via metode HTTP POST yang aman (tanpa JS alert/confirm).
   - Relasi Foreign Key `ON DELETE CASCADE` memastikan data terhapus secara bersih jika akun dihapus.
7. **Keluar / Logout (`pages/auth/logout.php`):**
   - Menghancurkan session dan menghapus cookie autentikasi.

---

## 🗄️ Struktur Database (`database/schema.sql`)
1. **Tabel `users`**: Menyimpan identitas akun, email unik, password hash, bio, dan nomor telepon.
2. **Tabel `learning_goals`**: Menyimpan target belajar per pengguna dengan relasi foreign key `user_id` ke tabel `users`.