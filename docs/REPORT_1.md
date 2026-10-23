# Laporan Mobile: Kekurangan Akses Perangkat Mobile

## Ringkasan
Website sudah memiliki beberapa breakpoint responsif, tetapi pengalaman mobile masih belum optimal. Masalah utama ada pada navigasi, target sentuh, tabel data, dan penggunaan ruang layar kecil.

## Temuan

### 1. Navigasi mobile tidak memiliki menu hamburger
- Tombol `.nav-toggle` disembunyikan pada `max-width: 760px`, tetapi tidak ada menu collapsible.
- Navigasi berubah menjadi baris yang membungkus (wrap), sehingga header menjadi tinggi dan berantakan pada layar kecil.

### 2. Target sentuh terlalu kecil
- `.nav-link` memakai padding `7px 8px` dan font `12px`.
- Tautan aksi tabel (Edit/Hapus) berukuran `12px` dengan gap kecil.
- Tombol kecil seperti `.btn-small` berisiko sulit disentuh secara akurat.

### 3. Tabel target belajar butuh scroll horizontal
- `.table-wrap` memakai `overflow-x: auto`.
- Pada mobile, pengguna harus geser horizontal untuk melihat semua kolom.
- Tabel dengan 6 kolom kurang ideal untuk layar sempit.

### 4. Form kurang nyaman di mobile
- Beberapa input memakai inline style, bukan kelas CSS konsisten.
- Select, textarea, dan input memiliki tinggi minimal `45px`, tetapi spacing dan label belum dioptimalkan untuk jempol.
- Form edit profil dan target belajar panjang, sehingga butuh scroll vertikal yang cukup.

### 5. Layout profil belum ideal untuk layar kecil
- `.profile-layout-grid` berubah menjadi satu kolom pada `max-width: 860px`.
- Kartu profil dan tabel menumpuk, tetapi urutan dan spacing belum dioptimalkan untuk mobile.

### 6. Hero dan visual memakan ruang berlebihan
- `.hero-visual` tetap ditampilkan pada mobile.
- Elemen dekoratif seperti `.floating-note` dapat mengganggu tampilan layar kecil.

### 7. Gambar belum dioptimalkan untuk mobile
- Gambar dipakai langsung tanpa `srcset` atau ukuran responsif khusus.
- Beberapa gambar besar dapat memperlambat loading pada jaringan mobile.

### 8. Teks dan spacing belum konsisten
- Beberapa halaman memakai inline style yang berbeda-beda.
- Ukuran font dan jarak antar elemen belum seragam pada breakpoint kecil.

## Rekomendasi

1. Implementasikan menu mobile yang benar-benar collapsible.
2. Perbesar target sentuh minimal 44x44 px.
3. Ubah tabel menjadi card list pada mobile atau kurangi kolom yang ditampilkan.
4. Standarkan form dengan kelas CSS, bukan inline style.
5. Sederhanakan hero mobile dengan menyembunyikan elemen dekoratif.
6. Optimalkan gambar dengan ukuran lebih kecil untuk mobile.
7. Uji pada lebar 360px, 390px, dan 414px.

## Kesimpulan
Website sudah responsif secara dasar, tetapi pengalaman mobile perlu perbaikan pada navigasi, tabel, form, dan target sentuh agar lebih nyaman digunakan pada perangkat seluler.
