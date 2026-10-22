<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/db.php';

$page_title = 'Katalog Kursus';
$current_page = 'course';
$base_url = '../';
require_once APP_ROOT . '/includes/header.php';
?>

<main>
    <section class="page-hero">
        <div class="container page-hero-grid">
            <div>
                <span class="eyebrow"><span class="eyebrow-dot"></span> KURSUS VIDEO MANDIRI</span>
                <h1>Buka potensimu:<br><span class="text-yellow">pelajari skill</span> yang kamu butuhkan.</h1>
                <p>Temukan materi belajar bertahap untuk membangun pemahaman dan praktik nyata.</p>
                <a class="btn btn-yellow" href="#katalog">Jelajahi kursus</a>
            </div>
            <div class="page-illustration">
                <img src="../assets/gambar_6.webp" alt="Ilustrasi Kursus Belajar" style="width: 100%; max-width: 420px; border-radius: 20px; box-shadow: 0 20px 45px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.2);">
            </div>
        </div>
    </section>

    <section class="section section-tint" id="katalog">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow eyebrow-light">KATALOG KURSUS</span>
                    <h2>Belajar sesuai minatmu</h2>
                    <p>Materi pilihan untuk mengawali perjalanan teknologimu.</p>
                </div>
                <div class="filter-pills">
                    <button class="filter-pill active" type="button">Semua</button>
                    <button class="filter-pill" type="button">Web</button>
                    <button class="filter-pill" type="button">Data</button>
                </div>
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
                        <div class="course-meta"><span>8 Materi</span><span>Pemula</span></div>
                        <div class="course-card-bottom">
                            <strong>Gratis</strong>
                            <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                        </div>
                    </div>
                </article>

                <article class="course-card">
                    <div class="course-art art-green">
                        <span class="pill">WEB PROGRAMMING</span>
                        <div class="art-symbol">{ }</div>
                        <h3>Dasar JavaScript</h3>
                        <p>Kenali logika untuk web interaktif.</p>
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta"><span>12 Materi</span><span>Pemula</span></div>
                        <div class="course-card-bottom">
                            <strong>Rp75.000</strong>
                            <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                        </div>
                    </div>
                </article>

                <article class="course-card">
                    <div class="course-art art-purple">
                        <span class="pill">DATABASE</span>
                        <div class="art-symbol">▤</div>
                        <h3>Pengantar Database</h3>
                        <p>Pahami tabel, relasi, dan query SQL dasar.</p>
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta"><span>10 Materi</span><span>Pemula</span></div>
                        <div class="course-card-bottom">
                            <strong>Rp90.000</strong>
                            <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                        </div>
                    </div>
                </article>

                <article class="course-card">
                    <div class="course-art art-orange">
                        <span class="pill">BACKEND</span>
                        <div class="art-symbol">PHP</div>
                        <h3>PHP Native &amp; MySQL</h3>
                        <p>Pelajari form, session, dan CRUD murni.</p>
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta"><span>14 Materi</span><span>Pemula</span></div>
                        <div class="course-card-bottom">
                            <strong>Rp100.000</strong>
                            <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                        </div>
                    </div>
                </article>

                <article class="course-card">
                    <div class="course-art art-cyan">
                        <span class="pill">TOOLS</span>
                        <div class="art-symbol">⌘</div>
                        <h3>Git &amp; GitHub</h3>
                        <p>Kelola versi kode dan kolaborasi tim.</p>
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta"><span>6 Materi</span><span>Pemula</span></div>
                        <div class="course-card-bottom">
                            <strong>Gratis</strong>
                            <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                        </div>
                    </div>
                </article>

                <article class="course-card">
                    <div class="course-art art-pink">
                        <span class="pill">DATA</span>
                        <div class="art-symbol">01</div>
                        <h3>Dasar Pengolahan Data</h3>
                        <p>Mulai memahami data secara praktis.</p>
                    </div>
                    <div class="course-card-body">
                        <div class="course-meta"><span>9 Materi</span><span>Pemula</span></div>
                        <div class="course-card-bottom">
                            <strong>Rp85.000</strong>
                            <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
