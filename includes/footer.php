<?php
$base_url = $base_url ?? '../';
?>
    <footer class="site-footer">
        <div class="container footer-main">
            <div class="footer-brand-block">
                <a class="brand brand-footer" href="<?= $base_url ?>index.php">
                    <span class="brand-mark">D</span>
                    <span>Belajar<span class="brand-accent">HTML</span></span>
                </a>
                <p>Ekosistem belajar teknologi berbasis komunitas, tempat bertumbuh, berbagi, dan membangun keterampilan digital.</p>
            </div>
            <div class="footer-col">
                <h4>Cara Belajar</h4>
                <a href="<?= $base_url ?>pages/event.php">Event &amp; Webinar</a>
                <a href="<?= $base_url ?>pages/course.php">Video Course</a>
                <a href="<?= $base_url ?>pages/mentoring.php">Private Mentoring</a>
            </div>
            <div class="footer-col">
                <h4>Komunitas</h4>
                <a href="<?= $base_url ?>pages/mentoring.php">Jadi Mentor</a>
                <a href="<?= $base_url ?>pages/blog.php">Blog &amp; Artikel</a>
                <a href="<?= $base_url ?>pages/tentang.php">Tentang Kami</a>
            </div>
            <div class="footer-col">
                <h4>Informasi</h4>
                <a href="<?= $base_url ?>pages/auth/login.php">Masuk</a>
                <a href="<?= $base_url ?>pages/auth/register.php">Daftar</a>
                <a href="<?= $base_url ?>pages/tentang.php#kontak">Kontak</a>
            </div>
        </div>
        <div class="container footer-bottom">
            <span>© 2026 Belajar HTML. Proyek pembelajaran.</span>
            <span>Dibuat oleh Masrul Hadi · 240705068</span>
        </div>
    </footer>
</body>
</html>
