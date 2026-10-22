<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../app/bootstrap.php';
$user = \App\Auth::user();
if (!$user) {
    \App\Redirect::to(base_url('/pages/auth/login.php'));
}
$flash = \App\Flash::pull();
$success = $flash['success'] ?? null;
$csrf = \App\Csrf::token();
$full = \App\Auth::find((int)$user['id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dashboard akun Belajar HTML.">
    <title>Dashboard | Belajar HTML</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <?php $navActive = ''; $baseDepth = 2; require __DIR__ . '/../../../app/views/partials/header.php'; ?>
    <main>
        <section class="login-section">
            <div class="container login-layout">
                <div class="login-card" style="max-width:560px;margin:0 auto;">
                    <h2>Dashboard Akun</h2>
                    <?php if ($success): ?>
                    <div class="form-notice form-success"><?= e($success) ?></div>
                    <?php endif; ?>
                    <p class="muted">Informasi akunmu:</p>
                    <ul>
                        <li><strong>Nama:</strong> <?= e($full['name'] ?? $user['name']) ?></li>
                        <li><strong>Email:</strong> <?= e($full['email'] ?? $user['email']) ?></li>
                        <li><strong>Role:</strong> <?= e($full['role'] ?? $user['role']) ?></li>
                        <li><strong>Bergabung:</strong> <?= e($full['created_at'] ?? '-') ?></li>
                        <li><strong>Login terakhir:</strong> <?= e($full['last_login_at'] ?? '-') ?></li>
                    </ul>
                    <form method="post" action="<?= e(base_url('/api/auth/logout.php')) ?>">
                        <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                        <button class="btn btn-primary btn-full" type="submit">Keluar</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <?php require __DIR__ . '/../../../app/views/partials/footer.php'; ?>
</body>
</html>
