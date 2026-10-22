<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/db.php';

$page_title = 'Blog & Artikel';
$current_page = 'blog';
$base_url = '../';
require_once APP_ROOT . '/includes/header.php';
?>

<main>
    <section class="page-hero">
        <div class="container page-hero-grid">
            <div>
                <span class="eyebrow"><span class="eyebrow-dot"></span> CATATAN &amp; WAWASAN</span>
                <h1>Ide baru untuk<br><span class="text-yellow">perjalanan belajarmu.</span></h1>
                <p>Baca artikel, tips belajar, dan catatan teknologi untuk menemani proses berkembangmu.</p>
                <a class="btn btn-yellow" href="#artikel">Baca artikel</a>
            </div>
            <div class="page-illustration">
                <div class="blog-paper">
                    <span class="blog-paper-kicker">BELAJAR / BERBAGI</span>
                    <div class="blog-paper-lines"></div>
                    <h3>Knowledge grows when shared.</h3>
                    <small>Catatan belajar komunitas</small>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-tint" id="artikel">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow eyebrow-light">ARTIKEL TERBARU</span>
                    <h2>Belajar lewat cerita</h2>
                    <p>Wawasan praktis seputar dunia web dan pemrograman.</p>
                </div>
            </div>
            <div class="card-grid three-col">
                <article class="article-card">
                    <img src="../assets/gambar_1.webp" alt="Ilustrasi aktivitas belajar" onerror="this.style.display='none'">
                    <div class="article-card-content">
                        <p class="article-meta">20 Okt 2026 · Tips Belajar</p>
                        <h3>
                            <a href="artikel-detail.php?artikel=mulai-belajar">Cara Memulai Belajar Programming dari Nol</a>
                        </h3>
                        <p>Mulai dari fondasi, praktik konsisten, dan jangan buru-buru mengejar tools.</p>
                        <a class="text-link" href="artikel-detail.php?artikel=mulai-belajar">Baca artikel</a>
                    </div>
                </article>

                <article class="article-card">
                    <img src="../assets/gambar_2.webp" alt="Ilustrasi produktivitas" onerror="this.style.display='none'">
                    <div class="article-card-content">
                        <p class="article-meta">15 Okt 2026 · Produktivitas</p>
                        <h3>
                            <a href="artikel-detail.php?artikel=belajar-konsisten">Membangun Kebiasaan Belajar yang Konsisten</a>
                        </h3>
                        <p>Strategi sederhana agar proses belajar lebih terarah dan realistis.</p>
                        <a class="text-link" href="artikel-detail.php?artikel=belajar-konsisten">Baca artikel</a>
                    </div>
                </article>

                <article class="article-card">
                    <img src="../assets/gambar_3.webp" alt="Ilustrasi kolaborasi" onerror="this.style.display='none'">
                    <div class="article-card-content">
                        <p class="article-meta">10 Okt 2026 · Karier</p>
                        <h3>
                            <a href="artikel-detail.php?artikel=portofolio">Portofolio Kecil yang Bisa Kamu Bangun</a>
                        </h3>
                        <p>Proyek sederhana tetap bernilai ketika dibuat dengan tujuan yang jelas.</p>
                        <a class="text-link" href="artikel-detail.php?artikel=portofolio">Baca artikel</a>
                    </div>
                </article>
            </div>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
