# Laporan Analisis Proyek: Belajar HTML

Dokumen ini berisi laporan analisis teknis terhadap proyek situs statis
"Belajar HTML". Tujuannya adalah mendokumentasikan kondisi proyek, temuan
masalah, serta rekomendasi perbaikan agar proyek lebih rapi, aksesibel,
cepat, aman, dan mudah dipelihara.

## 1. Ringkasan Eksekutif

Proyek ini adalah situs statis berbasis HTML5 dan CSS3 murni tanpa
JavaScript, framework, maupun proses build. Situs berfungsi sebagai
landing page dan katalog untuk platform pembelajaran (kursus, event,
mentoring, blog). Struktur berkas sudah dirapikan ke dalam folder
`pages/` dan `pages/auth/`.

Secara umum situs berjalan dengan baik pada ukuran layar desktop maupun
mobile, tanpa overflow horizontal, dan seluruh tautan internal dapat
diakses. Namun terdapat sejumlah temuan pada validitas HTML, aksesibilitas,
performa (terutama gambar), SEO, dan pemeliharaan yang perlu ditindaklanjuti.

Ringkasan temuan:

| Severity | Jumlah | Keterangan singkat |
|----------|--------|--------------------|
| Tinggi   | 8      | Validitas HTML, kontras warna, gambar besar, struktur header/footer berulang |
| Sedang   | 12     | Heading, tautan placeholder, SEO dasar, CSS duplikat, form statis |
| Rendah   | 10     | Konsistensi penulisan, penamaan aset, dokumentasi, metadata |

## 2. Ikhtisar Proyek

- Nama proyek: Belajar HTML
- Tipe: Situs statis (HTML + CSS)
- Cabang aktif: `main`
- Jumlah halaman HTML: 9
- Aset gambar: 6 berkas JPEG (total kurang lebih 7,8 MB)
- Stylesheet: `css/style.css` (kurang lebih 28 KB)
- JavaScript: tidak digunakan
- Dependensi eksternal: tidak ada
- Server pengembangan: server HTTP sederhana (Python)

## 3. Struktur Proyek

```
belajar-html/
├── app/                              # logika PHP (di luar web root)
│   ├── bootstrap.php
│   ├── migrate.php
│   ├── config/
│   │   ├── app.php
│   │   └── database.php
│   └── src/
│       ├── Auth.php, Database.php, Session.php, Csrf.php,
│       ├── Env.php, Flash.php, Validator.php, RateLimiter.php,
│       ├── Redirect.php, helpers.php
├── database/
│   ├── README.md
│   └── migrations/
│       ├── 001_create_users.sql
│       ├── 002_create_login_attempts.sql
│       └── 003_create_schema_migrations.sql
├── docker/
│   ├── mysql/init/001_schema.sql
│   └── web/
│       ├── Dockerfile
│       └── apache-vhost.conf
├── public/                           # document root Apache
│   ├── api/
│   │   ├── health.php
│   │   └── auth/
│   │       ├── login.php, register.php, logout.php
│   ├── assets/
│   ├── css/style.css
│   ├── index.html
│   └── pages/
│       ├── auth/
│       │   ├── login.php
│       │   ├── register.php
│       │   └── dashboard.php
│       ├── artikel-detail.html, blog.html, course.html,
│       ├── event.html, mentoring.html, tentang.html
├── .env.example
├── .gitignore
├── docker-compose.yml
└── README.md
```

## 4. Daftar Halaman

| Berkas | Fungsi |
|--------|--------|
| `public/index.html` | Halaman utama, hero, ringkasan kursus, testimonial, CTA |
| `public/pages/course.html` | Katalog kursus, filter, daftar kursus |
| `public/pages/event.html` | Daftar event dan webinar |
| `public/pages/mentoring.html` | Program mentoring dan mentor |
| `public/pages/blog.html` | Daftar artikel blog |
| `public/pages/artikel-detail.html` | Detail artikel (statis, satu templat) |
| `public/pages/tentang.html` | Tentang platform, nilai, kontak |
| `public/pages/auth/login.php` | Form masuk (terhubung MySQL) |
| `public/pages/auth/register.php` | Form daftar (terhubung MySQL) |
| `public/pages/auth/dashboard.php` | Halaman setelah login |

## 5. Stack Teknologi

- HTML5 semantik
- CSS3 dengan custom properties (variabel CSS)
- Tanpa JavaScript
- Tanpa framework CSS
- Tanpa bundler / package manager
- Gambar JPEG statis
- Font sistem (Inter dideklarasikan tetapi tidak dimuat dari sumber eksternal)
- PHP 8.2 (Apache) untuk autentikasi
- MySQL 8.0 untuk penyimpanan akun
- Docker Compose untuk lingkungan pengembangan

## 5.1 Integrasi PHP & MySQL

### Arsitektur

| Bagian | Lokasi | Keterangan |
|--------|---------|------------|
| Document root | `public/` | Satu-satunya folder yang dapat diakses lewat HTTP |
| Logika aplikasi | `app/` | Di luar document root, tidak bisa diunduh |
| Migrasi SQL | `database/migrations/` | Idempotent, dijalankan lewat `app/migrate.php` |
| Infrastruktur | `docker/` | Dockerfile Apache + init script MySQL |

Endpoint di `public/api/` sengaja dibuat tipis: isinya hanya memanggil kelas di
`app/src/`, tanpa logika maupun kredensial.

### Skema Database

Tabel `users`:

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `id` | INT UNSIGNED AI | Primary key |
| `name` | VARCHAR(100) | Nama pengguna |
| `email` | VARCHAR(191) | Unik, pencarian case-insensitive |
| `password_hash` | VARCHAR(255) | Hash bcrypt, bukan password mentah |
| `role` | ENUM('user','admin') | Peran pengguna |
| `is_active` | TINYINT(1) | Nonaktifkan akun tanpa menghapus |
| `remember_token` | CHAR(64) | SHA-256 dari selector+validator |
| `remember_token_expires` | DATETIME | Masa berlaku token "ingat saya" |
| `last_login_at` | DATETIME | Waktu login terakhir |
| `created_at` / `updated_at` | TIMESTAMP | Otomatis oleh MySQL |

Tabel `login_attempts` mencatat percobaan login (email, IP, sukses/tidak,
waktu) untuk rate limiting. Tabel `schema_migrations` melacak migrasi yang
sudah diterapkan.

### Endpoint

| Method | Endpoint | Keterangan |
|--------|----------|------------|
| POST | `/api/auth/register.php` | Validasi, cek duplikat email, simpan akun, auto-login |
| POST | `/api/auth/login.php` | Rate limit, verifikasi password, buat session |
| POST | `/api/auth/logout.php` | Hapus session dan cookie "ingat saya" |
| GET | `/api/health.php` | Status aplikasi dan koneksi database |

### Keamanan yang Diterapkan

- Password di-hash dengan `password_hash()` dan diverifikasi dengan
  `password_verify()`; `password_needs_rehash()` ditangani saat login.
- Seluruh query memakai prepared statement PDO dengan
  `ATTR_EMULATE_PREPARES = false`.
- Token CSRF per-sesi, diverifikasi dengan `hash_equals()`, dirotasi setiap
  kali login atau logout.
- Cookie session memakai flag `httponly`, `samesite=Lax`, `secure` saat
  HTTPS, `use_strict_mode`, dan `use_only_cookies`.
- `session_regenerate_id(true)` dijalankan saat login dan logout untuk
  mencegah session fixation.
- Login dibatasi 5 percobaan per 15 menit per kombinasi email dan IP.
- Output yang berasal dari input pengguna selalu di-escape dengan
  `htmlspecialchars()` melalui helper `e()`.
- Header `X-Content-Type-Options`, `X-Frame-Options`, dan `Referrer-Policy`
  dikirim pada setiap respons.
- Folder `app/`, `database/`, dan `docker/` berada di luar document root dan
  mengembalikan 404 bila diakses lewat HTTP.
- Kredensial hanya berada di `.env` yang tidak dilacak Git; `.env.example`
  disediakan sebagai acuan.

### Catatan Operasional

- Port default yang dipakai: `8090` (situs), `8091` (phpMyAdmin), `3307`
  (MySQL pada host). Nilai `8080`/`8081`/`3306` sering sudah dipakai XAMPP
  atau FlyEnv di komputer lokal.
- Image `php:8.2-apache` resmi belum membawa ekstensi `pdo_mysql`, sehingga
  `docker/web/Dockerfile` wajib melakukan `docker-php-ext-install pdo_mysql`.
- Compose hanya meng-*interpolate* variabel `${...}`; agar container web
  benar-benar menerima kredensial database, diperlukan `env_file: .env`
  sekaligus blok `environment:`.

## 6. Metodologi Analisis

Analisis dilakukan melalui:

- Inspeksi manual terhadap seluruh berkas HTML dan CSS.
- Pemeriksaan tautan internal (href dan src).
- Validasi HTML dengan html-validate.
- Pemeriksaan gaya CSS dengan Stylelint.
- Audit Lighthouse (aksesibilitas, praktik terbaik, SEO, agentic).
- Trace performa (Core Web Vitals) pada ukuran layar 375, 1280, dan 1920 px.
- Pemeriksaan keamanan dasar untuk situs statis.

## 7. Temuan

### 7.1 Validitas HTML

Severity: Tinggi

- Beberapa elemen `<button>` tidak memiliki atribut `type`, sehingga dapat
  berperilaku sebagai tombol submit bila berada di dalam form.
  Lokasi: tombol toggle navigasi di hampir semua halaman, tombol filter
  kursus/event, tombol tampilkan/sembunyikan password.
- `pages/blog.html` menggunakan gaya XHTML (self-closing pada void element
  seperti `<meta />`, `<link />`, `<img />`) yang tidak konsisten dengan
  halaman lain.
- `pages/course.html` mengandung entitas `&lt;/&gt;` di dalam elemen
  `.art-symbol` yang menyebabkan kesalahan parsing.
- `index.html` menggunakan inline style pada progress bar (80% dan 45%),
  yang melanggar pemisahan struktur dan presentasi serta menyulitkan
  penerapan Content Security Policy yang ketat.
- Formulir masuk dan daftar tidak memiliki atribut `action` dan `method`,
  sehingga bersifat demonstrasi (statis) dan tidak mengirim data.
- Tautan placeholder `href="#"` digunakan untuk "Lupa password?", "Syarat
  dan ketentuan", dan "Jadi Mentor", tanpa tujuan sebenarnya.

Severity: Sedang

- Semua tautan artikel blog mengarah ke `artikel-detail.html` yang sama,
  dengan parameter query yang diabaikan; konten detail tidak berubah.
- Tombol filter kategori (Semua, Gratis, Berbayar, dan lainnya) tidak
  memiliki fungsi karena tidak ada JavaScript.
- Toggle tampilkan/sembunyikan password tidak berfungsi tanpa JavaScript.
- Tombol toggle navigasi disembunyikan pada layar kecil, tetapi menu
  navigasi tetap tampil (wrap), sehingga tombol tersebut tidak diperlukan.

### 7.2 Aksesibilitas

Severity: Tinggi

- Kontras warna gagal pada teks `#6e7895` (rasio 4,39:1) dan
  `#6b78a3` (rasio 4,33:1) terhadap latar belakang putih. Keduanya
  di bawah ambang 4,5:1 untuk teks normal.
- Tombol tampilkan/sembunyikan password memiliki target sentuh kurang dari
  24 x 24 piksel.
- Label aksesibel tombol password ("Tampilkan password") tidak sesuai
  dengan teks visual ("Lihat"), sehingga pengguna pembaca layar
  mendapatkan informasi yang berbeda.

Severity: Sedang

- Tidak ada tautan "Lewati ke konten utama" (skip link).
- Tautan navigasi aktif tidak ditandai dengan `aria-current="page"`.
- Urutan heading tidak ideal: beberapa halaman memiliki `h3` di hero
  sebelum `h2`, dan footer menggunakan `h4` tanpa `h3` sebelumnya.
- Gambar tidak memiliki atribut `width` dan `height`, sehingga dapat
  menyebabkan pergeseran tata letak (CLS) saat dimuat.
- Gambar tidak menggunakan `loading="lazy"` dan `decoding="async"`.

Severity: Rendah

- Beberapa teks berukuran sangat kecil (8-9 px) pada label dan tombol,
  yang dapat mengurangi keterbacaan.
- Fokus keyboard pada beberapa elemen interaktif belum diberi gaya yang
  jelas dan konsisten.

### 7.3 Performa

Severity: Tinggi

- Gambar berukuran sangat besar: 5 berkas JPEG dengan dimensi 3840 x 2160
  dan 5184 x 3456, total kurang lebih 7,8 MB. Hanya 3 gambar yang
  digunakan pada halaman blog; gambar lainnya tidak dipakai tetapi tetap
  tersimpan di repositori.
- Tidak ada kompresi, pengubahan ukuran, maupun format modern
  (WebP/AVIF) untuk gambar.
- Tidak ada atribut `srcset` dan `sizes`, sehingga browser memuat gambar
  beresolusi tinggi bahkan pada layar kecil.

Severity: Sedang

- Tidak ada kompresi teks (gzip/brotli) pada server pengembangan; Lighthouse
  melaporkan DocumentLatency gagal kompresi.
- Tidak ada pengaturan cache (`Cache-Control`) pada server pengembangan.
- Stylesheet 28 KB tidak diminifikasi.
- Tidak ada service worker atau dukungan offline.

Severity: Rendah

- CSS berisi aturan media query duplikat (760 px dan 520 px) yang
  ditambahkan di bagian akhir, sehingga menimpa aturan sebelumnya secara
  berulang.
- Tidak ada versioning/cache busting pada berkas CSS.

Hasil trace performa menunjukkan CLS 0,00 dan tidak ada overflow horizontal
pada ukuran layar yang diuji.

### 7.4 SEO

Severity: Sedang

- Tidak ada favicon, manifest aplikasi, maupun ikon sentuh.
- Tidak ada tautan kanonis (`rel="canonical"`).
- Tidak ada metadata Open Graph dan Twitter Card.
- Tidak ada `robots.txt` dan `sitemap.xml`.
- Tidak ada data terstruktur (JSON-LD, misalnya Organization/Article).
- Tidak ada halaman 404 kustom.

Severity: Rendah

- Semua halaman memiliki `title` dan `meta description` yang unik
  (baik).
- Struktur semantik dan satu `h1` per halaman sudah baik.
- Hanya mendukung bahasa Indonesia (`lang="id"`), tanpa varian bahasa
  lain (sesuai kebutuhan saat ini).

### 7.5 Keamanan

Severity: Sedang

- Handler inline `onerror` pada gambar dapat diblokir oleh Content Security
  Policy yang ketat dan menambah risiko XSS jika tidak dikontrol.
- Tidak ada Content Security Policy, X-Frame-Options, atau header keamanan
  lainnya (tergantung hosting).
- Alamat email pribadi ditampilkan melalui `mailto:` dan teks biasa,
  sehingga mudah dipanen oleh bot.
- Formulir tidak memiliki validasi sisi server (karena statis); konfirmasi
  password pada halaman daftar tidak diperiksa kesesuaiannya.

Severity: Rendah

- Tidak ada dependensi eksternal, sehingga tidak ada risiko kerentanan
  pustaka pihak ketiga.
- Tidak ada kunci rahasia atau kredensial dalam repositori.
- Situs statis tidak memiliki backend, sehingga tidak ada risiko injeksi
  SQL atau CSRF.
- Akses HTTPS tergantung pada konfigurasi hosting.

### 7.6 Pemeliharaan

Severity: Tinggi

- Header dan footer diduplikasi di 9 halaman. Setiap perubahan navigasi
  atau footer harus dilakukan di semua berkas.
- Tidak ada sistem templating atau partial (misalnya include) untuk
  menyusun komponen bersama.

Severity: Sedang

- `css/style.css` berukuran 1925 baris dengan aturan media query duplikat,
  sehingga sulit dirawat.
- Penamaan aset tidak konsisten (`gambar1.jpg`, `gambar-belajar.jpg`,
  `gambar_orang_belajar.jpeg`).
- README sebelumnya hanya berisi nama dan NIM, tanpa dokumentasi proyek.
- `.gitignore` diatur untuk mengabaikan dirinya sendiri, dan berkas
  tersebut tidak lagi dilacak Git (commit "Stop tracking .gitignore"),
  sehingga aturan ignore tidak ikut terdistribusi ke klon baru.
- Tidak ada konfigurasi linting, pengujian, maupun CI/CD.

Severity: Rendah

- Tidak ada lisensi (LICENSE) dan panduan kontribusi.
- Tidak ada versioning semantik atau tag rilis.
- Atribut `class` pada beberapa elemen memiliki spasi berlebih
  (misalnya `nav-link `).

## 8. Skor Lighthouse (Desktop)

| Kategori | Skor | Catatan |
|----------|------|---------|
| Aksesibilitas | 92 | Kontras warna dan heading menjadi penyebab utama |
| Praktik Terbaik | 100 | Tidak ada masalah kritis |
| SEO | 100 | SEO dasar sudah baik |
| Agentic | 100 | Struktur semantik baik |

Catatan: kategori Performa tidak dijalankan sebagai skor penuh karena
pengujian dilakukan pada server pengembangan lokal.

## 9. Rekomendasi Prioritas

1. Perbaiki validitas HTML: tambahkan `type="button"` pada semua tombol
   non-submit, hapus inline style, perbaiki entitas pada `.art-symbol`,
   dan normalisasi penulisan void element.
2. Tingkatkan aksesibilitas: perbaiki kontras warna, tambahkan skip link
   dan `aria-current`, perbesar target sentuh tombol password, serta
   tambahkan `width`/`height` dan `loading="lazy"` pada gambar.
3. Optimalkan gambar: ubah ukuran, kompresi, gunakan WebP/AVIF, serta
   `srcset`/`sizes`; hapus gambar yang tidak digunakan.
4. Lengkapi SEO: favicon, canonical, Open Graph, Twitter Card,
   `robots.txt`, `sitemap.xml`, dan data terstruktur.
5. Terapkan header keamanan dan hapus handler inline; pertimbangkan
   obfuscation email.
6. Refaktor CSS: gabungkan media query duplikat dan minifikasi.
7. Kurangi duplikasi: gunakan templating/partial untuk header dan footer.
8. Tambahkan dokumentasi, linting, dan CI sederhana.

## 10. Risiko dan Batasan

- Situs ini statis dan tidak memiliki backend, sehingga fitur formulir
  (masuk, daftar, filter) tidak berfungsi secara nyata.
- Parameter query pada artikel diabaikan, sehingga semua artikel menampilkan
  konten yang sama.
- Kualitas performa sangat bergantung pada hosting produksi (kompresi,
  cache, HTTPS).
- Tidak ada pengujian otomatis, sehingga regresi visual dapat lolos.

## 11. Kesimpulan

Proyek "Belajar HTML" memiliki fondasi yang baik: struktur semantik,
desain responsif, dan tanpa dependensi eksternal. Namun terdapat temuan
pada validitas HTML, aksesibilitas, performa gambar, SEO, dan
pemeliharaan yang perlu ditangani. Dengan menerapkan rekomendasi
prioritas, kualitas proyek dapat meningkat secara signifikan tanpa
mengubah karakter statisnya.
