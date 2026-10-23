# Laporan Analisis Proyek: Belajar HTML

Dokumen ini berisi laporan analisis teknis terhadap proyek aplikasi web
"Belajar HTML". Tujuannya adalah mendokumentasikan kondisi proyek, temuan
masalah, serta rekomendasi perbaikan agar proyek lebih rapi, aksesibel,
cepat, aman, dan mudah dipelihara.

## 1. Ringkasan Eksekutif

Proyek ini adalah aplikasi web berbasis PHP, MySQL, HTML5, dan CSS3
tanpa framework maupun proses build. Situs berfungsi sebagai
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
├── assets/
│   ├── gambar1.jpg
│   ├── gambar2.jpg
│   ├── gambar3.jpg
│   ├── gambar4.jpg
│   ├── gambar-belajar.jpg
│   └── gambar_orang_belajar.jpeg
├── css/
│   └── style.css
├── pages/
│   ├── auth/
│   │   ├── login.html
│   │   └── register.html
│   ├── artikel-detail.html
│   ├── blog.html
│   ├── course.html
│   ├── event.html
│   ├── mentoring.html
│   └── tentang.html
├── .gitignore
├── index.html
└── README.md
```

## 4. Daftar Halaman

| Berkas | Fungsi |
|--------|--------|
| `index.html` | Halaman utama, hero, ringkasan kursus, testimonial, CTA |
| `pages/course.html` | Katalog kursus, filter, daftar kursus |
| `pages/event.html` | Daftar event dan webinar |
| `pages/mentoring.html` | Program mentoring dan mentor |
| `pages/blog.html` | Daftar artikel blog |
| `pages/artikel-detail.html` | Detail artikel (statis, satu templat) |
| `pages/tentang.html` | Tentang platform, nilai, kontak |
| `pages/auth/login.html` | Form masuk |
| `pages/auth/register.html` | Form daftar |

## 5. Stack Teknologi

- HTML5 semantik
- CSS3 dengan custom properties (variabel CSS)
- Tanpa JavaScript
- Tanpa framework CSS
- Tanpa bundler / package manager
- Gambar JPEG statis
- Font sistem (Inter dideklarasikan tetapi tidak dimuat dari sumber eksternal)

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
