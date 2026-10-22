<?php
define('APP_ROOT', __DIR__);
require_once APP_ROOT . '/config/db.php';

$page_title = 'Platform Belajar Web & Pemrograman';
$current_page = 'home';
$base_url = './';
require_once APP_ROOT . '/includes/header.php';
?>

<main>
    <section class="hero">
        <div class="container hero-grid">
            <div class="hero-copy">
                <span class="eyebrow"><span class="eyebrow-dot"></span> PLATFORM BELAJAR TEKNOLOGI</span>
                <h1>Tempat Kamu <span class="text-yellow">Belajar</span>, Bertumbuh &amp; Berkontribusi.</h1>
                <p>Temukan kelas, event, dan mentor yang membantumu mengembangkan skill teknologi. Belajar dengan terarah, bangun proyek nyata, dan tumbuh bersama komunitas.</p>
                
                <div class="hero-actions">
                    <?php if (is_logged_in()): ?>
                        <a class="btn btn-yellow" href="pages/profile.php">Buka Profil Belajarmu →</a>
                        <a class="btn btn-glass" href="pages/course.html">Jelajahi Kursus</a>
                    <?php else: ?>
                        <a class="btn btn-yellow" href="pages/auth/register.php">Mulai Daftar Gratis →</a>
                        <a class="btn btn-glass" href="pages/course.html">Jelajahi Kursus</a>
                    <?php endif; ?>
                </div>

                <div class="hero-proof">
                    <div class="avatar-stack">
                        <span>👨🏻‍💻</span><span>👩🏻‍💻</span><span>🧑🏽‍💻</span><span>👨🏽‍💻</span>
                    </div>
                    <span><strong>Komunitas belajar</strong><br>mulai dari langkah pertamamu</span>
                </div>
            </div>

            <div class="hero-visual">
                <div class="floating-note note-top">
                    <span class="note-icon">✓</span>
                    <span><b>Belajar terarah</b><small>Langkah demi langkah</small></span>
                </div>
                <div class="mock-window">
                    <div class="mock-top"><b>◈ Belajar HTML</b><span>● ● ●</span></div>
                    <div class="mock-content">
                        <span class="mock-label">KELAS PILIHAN</span>
                        <h3>Bangun skill.<br><span class="text-yellow">Wujudkan potensimu.</span></h3>
                        <div class="mock-progress">
                            <div><span>HTML &amp; CSS Dasar</span><b>80%</b></div>
                            <span class="progress-track"><i style="width:80%"></i></span>
                        </div>
                        <div class="mock-progress">
                            <div><span>PHP &amp; MySQL (CRUD)</span><b>100%</b></div>
                            <span class="progress-track"><i style="width:100%"></i></span>
                        </div>
                        <?php if (is_logged_in()): ?>
                            <a class="mock-button" href="pages/profile.php">Kelola Target Belajar →</a>
                        <?php else: ?>
                            <a class="mock-button" href="pages/auth/login.php">Masuk untuk Memulai →</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="floating-note note-bottom">
                    <span class="note-icon">✦</span>
                    <span><b>Belajar bareng</b><small>Komunitas yang suportif</small></span>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-strip">
        <div class="container stats-grid">
            <div><strong>01</strong><span>Mulai dari dasar</span></div>
            <div><strong>02</strong><span>Belajar terstruktur</span></div>
            <div><strong>03</strong><span>Bangun portofolio</span></div>
            <div><strong>04</strong><span>Tumbuh bersama</span></div>
        </div>
    </section>

    <section class="section section-light" id="cara-belajar">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow eyebrow-light">PILIH CARA BELAJARMU</span>
                    <h2>Belajar sesuai <span class="text-blue">kebutuhanmu</span></h2>
                    <p>Mulai dari materi dasar sampai pendampingan yang lebih personal.</p>
                </div>
                <a class="text-link" href="pages/course.html">Lihat semua program →</a>
            </div>
            <div class="feature-grid">
                <article class="feature-card">
                    <span class="feature-icon">▤</span>
                    <h3>Video Course</h3>
                    <p>Pelajari materi secara mandiri dengan alur yang jelas dan bisa diulang kapan saja.</p>
                    <a href="pages/course.html">Jelajahi kursus →</a>
                </article>
                <article class="feature-card">
                    <span class="feature-icon">◉</span>
                    <h3>Event &amp; Webinar</h3>
                    <p>Ikuti sesi belajar, webinar, dan diskusi bersama praktisi teknologi.</p>
                    <a href="pages/event.html">Lihat event →</a>
                </article>
                <article class="feature-card">
                    <span class="feature-icon">✦</span>
                    <h3>Private Mentoring</h3>
                    <p>Dapatkan arahan yang lebih fokus untuk mengembangkan skill dan portofolio.</p>
                    <a href="pages/mentoring.html">Kenali mentoring →</a>
                </article>
            </div>
        </div>
    </section>

    <section class="section section-tint">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow eyebrow-light">MULAI DARI SINI</span>
                    <h2>Kursus pilihan untuk <span class="text-blue">langkah pertamamu</span></h2>
                    <p>Contoh katalog kursus yang siap dipelajari.</p>
                </div>
                <a class="text-link" href="pages/course.html">Semua kursus →</a>
            </div>
            <div class="card-grid three-col">
                <article class="course-card">
                    <div class="course-art art-blue">
                        <span class="pill">WEB PROGRAMMING</span>
                        <div class="art-symbol">&lt;/&gt;</div>
                        <h3>HTML &amp; CSS untuk Pemula</h3>
                        <p>Bangun halaman web pertamamu dari nol.</p>
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta"><span>◷ 8 Materi</span><span>◉ Pemula</span></div>
                        <div class="course-card-bottom"><strong>Gratis</strong><a href="pages/course.html">Lihat detail →</a></div>
                    </div>
                </article>
                <article class="course-card">
                    <div class="course-art art-green">
                        <span class="pill">WEB PROGRAMMING</span>
                        <div class="art-symbol">{ }</div>
                        <h3>PHP &amp; MySQL Fundamental</h3>
                        <p>Kuasai backend dasar, PDO, dan CRUD murni.</p>
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta"><span>◷ 12 Materi</span><span>◉ Pemula</span></div>
                        <div class="course-card-bottom"><strong>Gratis</strong><a href="pages/course.html">Lihat detail →</a></div>
                    </div>
                </article>
                <article class="course-card">
                    <div class="course-art art-purple">
                        <span class="pill">DATABASE</span>
                        <div class="art-symbol">▤</div>
                        <h3>Pengantar Database Relasional</h3>
                        <p>Pahami tabel, relasi, dan query SQL dasar.</p>
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta"><span>◷ 10 Materi</span><span>◉ Pemula</span></div>
                        <div class="course-card-bottom"><strong>Gratis</strong><a href="pages/course.html">Lihat detail →</a></div>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section class="section section-dark">
        <div class="container cta-band">
            <div>
                <span class="eyebrow">LANGKAH PERTAMA DIMULAI DI SINI</span>
                <h2>Kelola target belajarmu<br>sekarang juga.</h2>
                <p>Daftar akun dan catat progres pembelajaranmu di dashboard profil.</p>
            </div>
            <a class="btn btn-yellow" href="<?= is_logged_in() ? 'pages/profile.php' : 'pages/auth/register.php' ?>">
                <?= is_logged_in() ? 'Buka Profil Saya →' : 'Daftar Akun Baru →' ?>
            </a>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
