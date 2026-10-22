<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/db.php';

$page_title = 'Detail Artikel';
$current_page = 'blog';
$base_url = '../';
require_once APP_ROOT . '/includes/header.php';
?>

<main>
    <section class="section section-light">
        <div class="container article-detail-container">
            <a class="text-link" href="blog.php">← Kembali ke Blog</a>
            <p class="article-meta">20 Okt 2026 · Tips Belajar</p>
            <h1 id="articleTitle">Cara Memulai Belajar Programming dari Nol</h1>
            <p class="article-lead">Mulai dari fondasi, praktik secara konsisten, dan jangan buru-buru mengejar tools.</p>
            <div class="article-detail-banner">&lt;/&gt;</div>
            
            <h2>Mulai dari satu tujuan</h2>
            <p>Belajar programming terasa luas karena ada banyak bahasa, framework, dan tools. Untuk memulai, tentukan dulu hal sederhana yang ingin kamu buat. Tujuan kecil membuat proses belajar lebih terarah.</p>
            
            <h2>Pahami fondasinya</h2>
            <p>Pelajari konsep inti sebelum berpindah ke teknologi berikutnya. Untuk web, mulai dari HTML untuk struktur, CSS untuk tampilan, lalu PHP dan SQL untuk backend dan database.</p>
            
            <h2>Praktik dan dokumentasikan</h2>
            <p>Buat proyek kecil, catat hal yang kamu pelajari, dan simpan perubahan kode dengan version control seperti Git. Konsistensi lebih berguna daripada menumpuk materi tutorial tanpa praktik langsung.</p>
            
            <div class="article-callout">
                Tip: pilih satu materi, praktikkan, lalu evaluasi pemahaman sebelum lanjut ke topik berikutnya.
            </div>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
