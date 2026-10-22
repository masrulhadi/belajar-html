<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../app/bootstrap.php';
$flash = \App\Flash::pull();
$errors = is_array($flash['errors'] ?? null) ? $flash['errors'] : [];
$old = is_array($flash['old'] ?? null) ? $flash['old'] : [];
$success = $flash['success'] ?? null;
$csrf = \App\Csrf::token();
$user = \App\Auth::user();
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman masuk Belajar HTML.">
    <title>Masuk | Belajar HTML</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <?php $navActive = ''; $baseDepth = 2; require __DIR__ . '/../../../app/views/partials/header.php'; ?>
    <main>
        <section class="login-section">
            <div class="container login-layout">
                <div class="login-intro"><a class="brand brand-login" href="../../index.html"><span
                            class="brand-mark">D</span><span>Belajar<span
                                class="brand-accent">HTML</span></span></a><span class="eyebrow"><span
                            class="eyebrow-dot"></span> SELAMAT DATANG KEMBALI</span>
                    <h1>Teruskan perjalanan <span class="text-yellow">belajarmu.</span></h1>
                    <p>Masuk untuk melanjutkan pengalaman belajar bersama Belajar HTML.</p>
                    <div class="login-benefit">✓ Akses materi dan program belajar</div>
                    <div class="login-benefit">✓ Ikuti perkembangan komunitas</div>
                </div>
                <div class="login-card">
                    <h2>Masuk ke akun</h2>
                    <p class="muted">Masukkan informasi akunmu di bawah ini.</p>
                    <?php if (!empty($errors['_global'])): ?>
                    <div class="form-notice form-error"><?= e($errors['_global']) ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                    <div class="form-notice form-success"><?= e($success) ?></div>
                    <?php endif; ?>
                    <form method="post" action="<?= e(base_url('/api/auth/login.php')) ?>">
                        <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email"
                            placeholder="nama@email.com" autocomplete="email" required
                            value="<?= e($old['email'] ?? '') ?>">
                        <?php if (!empty($errors['email'])): ?><div class="form-notice form-error"><?= e($errors['email']) ?></div><?php endif; ?>
                        <label for="password">Password</label>
                        <div class="password-wrap"><input type="password" id="password" name="password"
                                placeholder="Masukkan password" autocomplete="current-password" required>
                            <button type="button" aria-label="Tampilkan password">Lihat</button></div>
                        <?php if (!empty($errors['password'])): ?><div class="form-notice form-error"><?= e($errors['password']) ?></div><?php endif; ?>
                        <div class="form-row"><label class="checkbox-label"><input type="checkbox" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>>
                                Ingat saya</label><a href="#" class="text-link">Lupa password?</a></div>
                        <button class="btn btn-primary btn-full" type="submit">Masuk</button>
                    </form>
                    <div class="login-foot">Belum punya akun? <a href="register.php">Daftar di sini</a></div>
                </div>
            </div>
        </section>
    </main>
    <?php require __DIR__ . '/../../../app/views/partials/footer.php'; ?>
</body>

</html>