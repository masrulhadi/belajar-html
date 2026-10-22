<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/db.php';

$page_title = 'Tentang Kami';
$current_page = 'tentang';
$base_url = '../';
require_once APP_ROOT . '/includes/header.php';
?>

<main>
    <section class="page-hero">
        <div class="container page-hero-grid">
            <div>
                <span class="eyebrow"><span class="eyebrow-dot"></span> TENTANG BELAJAR HTML</span>
                <h1>Tempat bertumbuh<br><span class="text-yellow">bersama komunitas.</span></h1>
                <p>Belajar HTML adalah konsep platform pembelajaran teknologi yang menghubungkan materi, event, dan mentoring dalam satu pengalaman belajar.</p>
                <a class="btn btn-yellow" href="course.php">Mulai belajar →</a>
            </div>
            <div class="page-illustration">
                <div class="about-orbit">
                    <span>HTML</span><span>CSS</span><span>PHP</span><span>SQL</span>
                    <div class="about-center">D</div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-light">
        <div class="container split-section">
            <div class="split-copy">
                <span class="eyebrow eyebrow-light">VISI KAMI</span>
                <h2>Belajar teknologi jadi lebih <span class="text-blue">terarah</span></h2>
                <p>Proses belajar terasa lebih mudah ketika materi disusun bertahap, praktik menjadi bagian utama, dan tersedia ruang untuk bertanya serta berbagi.</p>
                <ul class="check-list">
                    <li><span>✓</span> Materi yang mudah diikuti</li>
                    <li><span>✓</span> Praktik untuk membangun pemahaman</li>
                    <li><span>✓</span> Komunitas yang saling mendukung</li>
                </ul>
            </div>
            <div class="about-values">
                <article>
                    <span>01</span>
                    <div>
                        <h3>Belajar</h3>
                        <p>Mulai dari fondasi dan pahami konsep inti.</p>
                    </div>
                </article>
                <article>
                    <span>02</span>
                    <div>
                        <h3>Praktik</h3>
                        <p>Ubah pengetahuan menjadi proyek nyata.</p>
                    </div>
                </article>
                <article>
                    <span>03</span>
                    <div>
                        <h3>Berkembang</h3>
                        <p>Evaluasi progres dan lanjutkan ke tantangan baru.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="section section-tint" id="kontak">
        <div class="container contact-panel">
            <div>
                <span class="eyebrow eyebrow-light">TERHUBUNG</span>
                <h2>Punya pertanyaan atau ide?</h2>
                <p>Halaman kontak ini dapat digunakan untuk mengirim pesan atau saran terkait pembelajaran.</p>
            </div>
            <a class="btn btn-primary" href="mailto:masrul.hadi.id@gmail.com">Hubungi kami →</a>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
