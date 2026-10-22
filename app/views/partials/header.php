<?php
/**
 * Partial header dinamis.
 * Variabel opsional: $pageTitle, $navActive, $baseDepth (jumlah level folder dari public/).
 */
$pageTitle = $pageTitle ?? 'Belajar HTML';
$navActive = $navActive ?? '';
$depth = $baseDepth ?? 0;
$prefix = str_repeat('../', $depth);
$user = $user ?? \App\Auth::user();
$csrf = $csrf ?? \App\Csrf::token();
?>
<header class="site-header">
    <div class="container nav-wrap">
        <a class="brand" href="<?= e(base_url('/index.html')) ?>"><span class="brand-mark">D</span><span>Belajar<span
                    class="brand-accent">HTML</span></span></a>
        <button class="nav-toggle" aria-label="Buka navigasi"><span></span><span></span><span></span></button>
        <nav class="primary-nav" aria-label="Navigasi utama">
            <a class="nav-link <?= $navActive === 'home' ? 'active' : '' ?>" href="<?= e(base_url('/index.html')) ?>">Home</a>
            <a class="nav-link <?= $navActive === 'event' ? 'active' : '' ?>" href="<?= e(base_url('/pages/event.html')) ?>">Event</a>
            <a class="nav-link <?= $navActive === 'course' ? 'active' : '' ?>" href="<?= e(base_url('/pages/course.html')) ?>">Course</a>
            <a class="nav-link <?= $navActive === 'mentoring' ? 'active' : '' ?>" href="<?= e(base_url('/pages/mentoring.html')) ?>">Mentoring</a>
            <a class="nav-link <?= $navActive === 'blog' ? 'active' : '' ?>" href="<?= e(base_url('/pages/blog.html')) ?>">Blog</a>
            <div class="nav-actions">
<?php if ($user): ?>
                <span class="muted">Halo, <?= e($user['name']) ?></span>
                <form method="post" action="<?= e(base_url('/api/auth/logout.php')) ?>" style="display:inline">
                    <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                    <button class="btn btn-outline btn-small" type="submit">Keluar</button>
                </form>
<?php else: ?>
                <a class="btn btn-outline btn-small" href="<?= e(base_url('/pages/auth/login.php')) ?>">Masuk</a>
                <a class="btn btn-primary btn-small" href="<?= e(base_url('/pages/course.html')) ?>">Mulai Belajar →</a>
<?php endif; ?>
            </div>
        </nav>
    </div>
</header>
