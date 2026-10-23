<?php
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}
require_once APP_ROOT . '/config/db.php';

$base_url = $base_url ?? '../';
$current_page = $current_page ?? '';
$page_title = $page_title ?? 'Belajar HTML';
$logged_in = is_logged_in();
$user_data = $logged_in ? get_current_user_data() : null;
$flash = get_flash_message();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Platform belajar web modern dan fundamental.">
    <title><?= e($page_title) ?> | Belajar HTML</title>
    <link rel="stylesheet" href="<?= $base_url ?>css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container nav-wrap">
            <a class="brand" href="<?= $base_url ?>index.php">
                <span class="brand-mark">D</span>
                <span>Belajar<span class="brand-accent">HTML</span></span>
            </a>
            <button class="nav-toggle" type="button" aria-label="Buka navigasi">
                <span></span><span></span><span></span>
            </button>
            <nav class="primary-nav" aria-label="Navigasi utama">
                <a class="nav-link <?= $current_page === 'home' ? 'active' : '' ?>" href="<?= $base_url ?>index.php">Home</a>
                <a class="nav-link <?= $current_page === 'event' ? 'active' : '' ?>" href="<?= $base_url ?>pages/event.php">Event</a>
                <a class="nav-link <?= $current_page === 'course' ? 'active' : '' ?>" href="<?= $base_url ?>pages/course.php">Course</a>
                <a class="nav-link <?= $current_page === 'mentoring' ? 'active' : '' ?>" href="<?= $base_url ?>pages/mentoring.php">Mentoring</a>
                <a class="nav-link <?= $current_page === 'blog' ? 'active' : '' ?>" href="<?= $base_url ?>pages/blog.php">Blog</a>
                
                <div class="nav-actions">
                    <?php if ($logged_in && $user_data): ?>
                        <a class="btn btn-outline btn-small <?= $current_page === 'profile' ? 'active' : '' ?>" href="<?= $base_url ?>pages/profile/index.php">
                            👤 <?= e(explode(' ', $user_data['nama'])[0]) ?>
                        </a>
                        <a class="btn btn-primary btn-small" href="<?= $base_url ?>pages/auth/logout.php">Keluar</a>
                    <?php else: ?>
                        <a class="btn btn-outline btn-small" href="<?= $base_url ?>pages/auth/login.php">Masuk</a>
                        <a class="btn btn-primary btn-small" href="<?= $base_url ?>pages/auth/register.php">Daftar</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>

    <?php if ($flash): ?>
        <div class="container" style="margin-top: 20px;">
            <div class="alert alert-<?= e($flash['type']) ?>">
                <?= e($flash['message']) ?>
            </div>
        </div>
    <?php endif; ?>
