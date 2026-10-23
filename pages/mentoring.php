<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/db.php';

$page_title = 'Private Mentoring';
$current_page = 'mentoring';
$base_url = '../';
require_once APP_ROOT . '/includes/header.php';
?>

<main>
    <section class="page-hero">
        <div class="container page-hero-grid">
            <div>
                <span class="eyebrow"><span class="eyebrow-dot"></span> GET CLOSER WITH MENTORING</span>
                <h1>Belajar intensif<br><span class="text-yellow">&amp; berkembang</span> bersama mentor.</h1>
                <p>Dapatkan arahan personal untuk membangun skill, menyelesaikan proyek, dan merencanakan langkah berikutnya.</p>
                <div class="hero-actions">
                    <a class="btn btn-yellow" href="#program">Explore Program</a>
                    <a class="btn btn-glass" href="tentang.php#kontak">Konsultasi</a>
                </div>
            </div>
            <div class="page-illustration">
                <img src="../assets/images/gambar_4.webp" alt="Ilustrasi mentoring" style="width: 100%; max-width: 420px; border-radius: 20px; box-shadow: 0 20px 45px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.2);">
            </div>
        </div>
    </section>

    <section class="section section-tint" id="program">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow eyebrow-light">PROGRAM MENTORING</span>
                    <h2>Temukan jalur berkembangmu</h2>
                    <p>Program bimbingan terarah bersama praktisi.</p>
                </div>
            </div>
            <div class="card-grid three-col">
                <article class="mentor-card">
                    <div class="mentor-card-art art-blue">
                        <span class="mentor-emoji">💻</span>
                        <span class="pill">FRONTEND</span>
                    </div>
                    <div class="mentor-card-content">
                        <h3>Frontend Web Development</h3>
                        <p>Belajar membangun antarmuka web.</p>
                        <ul>
                            <li>Dasar HTML &amp; CSS</li>
                            <li>Responsive layout</li>
                            <li>Mini project</li>
                        </ul>
                        <div class="course-card-bottom">
                            <strong>Mulai Rp150.000</strong>
                            <a href="<?= is_logged_in() ? 'profile/index.php' : 'auth/login.php' ?>">Detail</a>
                        </div>
                    </div>
                </article>

                <article class="mentor-card">
                    <div class="mentor-card-art art-purple">
                        <span class="mentor-emoji">🎨</span>
                        <span class="pill">UI/UX</span>
                    </div>
                    <div class="mentor-card-content">
                        <h3>UI/UX Design Fundamental</h3>
                        <p>Kenali user flow, wireframe, dan prototype.</p>
                        <ul>
                            <li>Design thinking</li>
                            <li>Wireframe &amp; prototype</li>
                            <li>Review desain</li>
                        </ul>
                        <div class="course-card-bottom">
                            <strong>Mulai Rp150.000</strong>
                            <a href="<?= is_logged_in() ? 'profile/index.php' : 'auth/login.php' ?>">Detail</a>
                        </div>
                    </div>
                </article>

                <article class="mentor-card">
                    <div class="mentor-card-art art-green">
                        <span class="mentor-emoji">📊</span>
                        <span class="pill">DATA</span>
                    </div>
                    <div class="mentor-card-content">
                        <h3>Data Analytics Starter</h3>
                        <p>Mulai mengolah data dan menyusun insight.</p>
                        <ul>
                            <li>Dasar spreadsheet</li>
                            <li>Data cleaning</li>
                            <li>Mini dashboard</li>
                        </ul>
                        <div class="course-card-bottom">
                            <strong>Mulai Rp150.000</strong>
                            <a href="<?= is_logged_in() ? 'profile/index.php' : 'auth/login.php' ?>">Detail</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
