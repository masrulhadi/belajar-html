# Belajar HTML

Ekosistem belajar teknologi berbasis komunitas untuk kursus, event, mentoring,
dan artikel.

- **Nama**: Masrul Hadi
- **NIM**: 240705068
- **Stack**: HTML5, CSS3, PHP 8.2, MySQL 8.0, Docker Compose

Dokumentasi analisis teknis tersedia di [DESCRIPTION.md](DESCRIPTION.md).

## Menjalankan Proyek

### Prasyarat

- Docker Desktop / Docker Engine + Docker Compose v2

### Langkah

1. Siapkan file environment (belum pernah ada di repo):

   ```bash
   cp .env.example .env
   ```

   Lalu ganti `DB_ROOT_PASSWORD` di `.env` dengan password pilihan Anda.

2. Jalankan stack:

   ```bash
   docker compose up -d --build
   ```

3. Akses aplikasi:

   | Layanan        | URL                          |
   |----------------|------------------------------|
   | Situs          | http://localhost:8090        |
   | phpMyAdmin     | http://localhost:8091        |
   | MySQL (host)   | `localhost:3307`             |

   Port default `8080`/`8081`/`3306` dapat diubah di `docker-compose.yml`
   bila sudah dipakai aplikasi lain di komputer Anda.

### Perintah Docker yang Sering Dipakai

```bash
docker compose ps                       # status container
docker compose logs -f web               # log Apache/PHP
docker compose down                     # stop container
docker compose down -v                  # stop + hapus volume (data DB hilang)
docker compose exec web php /var/www/app/migrate.php   # jalankan migrasi
```

## Struktur Proyek

```
belajar-html/
├── app/          # logika PHP (di luar web root, tidak bisa diakses via HTTP)
├── database/     # migrasi SQL
├── docker/       # Dockerfile Apache + init script MySQL
├── public/       # document root: halaman, CSS, aset, endpoint API
└── docker-compose.yml
```

Rincian lengkap ada di [DESCRIPTION.md](DESCRIPTION.md) bagian 3 dan 4.

## Fitur

- Halaman statis: beranda, katalog kursus, event, mentoring, blog, detail artikel,
  tentang kami.
- Autentikasi (terhubung MySQL):
  - Daftar akun di `/pages/auth/register.php`
  - Masuk di `/pages/auth/login.php`
  - Dashboard akun di `/pages/auth/dashboard.php`
- Endpoint API:

  | Method | Endpoint                  | Keterangan                        |
  |--------|---------------------------|-----------------------------------|
  | POST   | `/api/auth/register.php`  | Buat akun baru                    |
  | POST   | `/api/auth/login.php`     | Masuk                             |
  | POST   | `/api/auth/logout.php`    | Keluar                            |
  | GET    | `/api/health.php`         | Cek status aplikasi & koneksi DB  |

## Keamanan

- Password disimpan sebagai hash bcrypt (`password_hash` / `password_verify`).
- Seluruh query memakai prepared statement PDO (tanpa interpolasi SQL).
- Token CSRF per-sesi diverifikasi dengan `hash_equals` pada setiap POST.
- Cookie session: `httponly`, `samesite=Lax`, `secure` saat HTTPS, dan
  `session_regenerate_id` setiap kali login/logout.
- Login dibatasi 5 percobaan per 15 menit (per email + IP).
- Folder `app/`, `database/`, dan `docker/` berada di luar document root sehingga
  tidak bisa diunduh lewat HTTP.
- Nilai rahasia hanya disimpan di `.env` (tidak di-commit); `.env.example`
  tersedia sebagai acuan.

## Catatan

- `.env` sengaja tidak ikut dilacak Git. Pastikan Anda sudah menyalin
  `.env.example` sebelum menjalankan proyek di komputer lain.
- Semua migrasi SQL bersifat idempotent dan dapat dijalankan ulang.
