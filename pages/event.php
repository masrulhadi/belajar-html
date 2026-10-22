<?php
define('APP_ROOT', dirname(__DIR__));
require_once APP_ROOT . '/config/db.php';

$page_title = 'Event & Webinar';
$current_page = 'event';
$base_url = '../';
require_once APP_ROOT . '/includes/header.php';
?>

<main>
    <section class="page-hero">
        <div class="container page-hero-grid">
            <div>
                <span class="eyebrow"><span class="eyebrow-dot"></span> EVENT BELAJAR &amp; WEBINAR</span>
                <h1>Cari bakatmu.<br><span class="text-yellow">Telusuri event</span> menarik hari ini.</h1>
                <p>Ikuti webinar, workshop, dan sesi berbagi untuk membuka perspektif baru dalam dunia teknologi.</p>
                <a class="btn btn-yellow" href="#daftar-event">Lihat semua event</a>
            </div>
            <div class="page-illustration">
                <div class="event-screen">
                    <span class="pill">UPCOMING EVENT</span>
                    <div class="date-box"><b>26</b><span>OKT 2026</span></div>
                    <h3>Belajar teknologi bersama komunitas</h3>
                    <p>Live session · Online</p>
                    <div class="screen-line"></div>
                    <div class="screen-line short"></div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-tint" id="daftar-event">
        <div class="container">
            <div class="section-heading">
                <div>
                    <span class="eyebrow eyebrow-light">AGENDA KOMUNITAS</span>
                    <h2>Event mendatang</h2>
                    <p>Jadwal sesi belajar dan webinar komunitas.</p>
                </div>
                <div class="filter-pills">
                    <button class="filter-pill active" type="button">Semua</button>
                    <button class="filter-pill" type="button">Online</button>
                    <button class="filter-pill" type="button">Workshop</button>
                </div>
            </div>

            <div class="card-grid three-col">
                <article class="event-card">
                    <div class="event-card-top">
                        <span class="pill">ONLINE EVENT</span>
                        <div class="date-box"><b>26</b><span>OKT 2026</span></div>
                        <h3>Pengantar QA Automation untuk Pemula</h3>
                        <p>Kenali dasar pengujian perangkat lunak.</p>
                    </div>
                    <div class="event-card-bottom">
                        <span>19.30 WIB</span>
                        <span>Gratis</span>
                        <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                    </div>
                </article>

                <article class="event-card">
                    <div class="event-card-top">
                        <span class="pill">WEBINAR</span>
                        <div class="date-box"><b>29</b><span>OKT 2026</span></div>
                        <h3>Membangun Portofolio Data Analyst</h3>
                        <p>Susun proyek yang relevan untuk portofolio.</p>
                    </div>
                    <div class="event-card-bottom">
                        <span>19.30 WIB</span>
                        <span>Gratis</span>
                        <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                    </div>
                </article>

                <article class="event-card">
                    <div class="event-card-top">
                        <span class="pill">WORKSHOP</span>
                        <div class="date-box"><b>02</b><span>NOV 2026</span></div>
                        <h3>Git dan GitHub untuk Kolaborasi</h3>
                        <p>Latihan version control dan workflow tim.</p>
                    </div>
                    <div class="event-card-bottom">
                        <span>14.00 WIB</span>
                        <span>Rp25.000</span>
                        <a href="<?= is_logged_in() ? 'profile.php' : 'auth/login.php' ?>">Lihat detail</a>
                    </div>
                </article>
            </div>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
