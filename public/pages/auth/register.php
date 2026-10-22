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
    <meta name="description" content="Daftar akun baru di Belajar HTML.">
    <title>Daftar | Belajar HTML</title>
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
                            class="eyebrow-dot"></span> BUAT AKUN BARU</span>
                    <h1>Mulai perjalanan <span class="text-yellow">belajarmu.</span></h1>
                    <p>Daftar gratis dan akses semua materi, event, serta mentoring yang tersedia.</p>
                    <div class="login-benefit">✓ Akses semua course &amp; materi</div>
                    <div class="login-benefit">✓ Ikuti event komunitas</div>
                    <div class="login-benefit">✓ Dampingan mentor sesuai kebutuhan</div>
                </div>
                <div class="login-card">
                    <h2>Daftar akun baru</h2>
                    <p class="muted">Isi data berikut untuk membuat akunmu.</p>
                    <?php if (!empty($errors['_global'])): ?>
                    <div class="form-notice form-error"><?= e($errors['_global']) ?></div>
                    <?php endif; ?>
                    <?php if ($success): ?>
                    <div class="form-notice form-success"><?= e($success) ?></div>
                    <?php endif; ?>
                    <form method="post" action="<?= e(base_url('/api/auth/register.php')) ?>">
                        <input type="hidden" name="_token" value="<?= e($csrf) ?>">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap"
                            autocomplete="name" required value="<?= e($old['nama'] ?? '') ?>">
                        <?php if (!empty($errors['nama'])): ?>
                        <div class="form-notice form-error"><?= e($errors['nama']) ?></div>
                        <?php endif; ?>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="nama@email.com"
                            autocomplete="email" required value="<?= e($old['email'] ?? '') ?>">
                        <?php if (!empty($errors['email'])): ?>
                        <div class="form-notice form-error"><?= e($errors['email']) ?></div>
                        <?php endif; ?>
                        <label for="password">Password</label>
                        <div class="password-wrap"><input type="password" id="password" name="password"
                                placeholder="Buat password (min. 8 karakter)" minlength="8"
                                autocomplete="new-password" required><button type="button"
                                aria-label="Tampilkan password">Lihat</button></div>
                        <?php if (!empty($errors['password'])): ?>
                        <div class="form-notice form-error"><?= e($errors['password']) ?></div>
                        <?php endif; ?>
                        <label for="confirm-password">Konfirmasi Password</label>
                        <div class="password-wrap"><input type="password" id="confirm-password"
                                name="confirm-password" placeholder="Ulangi password" minlength="8"
                                autocomplete="new-password" required><button type="button"
                                aria-label="Tampilkan password">Lihat</button></div>
                        <?php if (!empty($errors['confirm-password'])): ?>
                        <div class="form-notice form-error"><?= e($errors['confirm-password']) ?></div>
                        <?php endif; ?>
                        <div class="form-row"><label class="checkbox-label"><input type="checkbox" name="syarat" required <?= isset($_POST['syarat']) ? 'checked' : '' ?>>
                                Saya setuju dengan <a href="#" class="text-link">syarat &amp; ketentuan</a></label>
                        </div>
                        <?php if (!empty($errors['syarat'])): ?>
                        <div class="form-notice form-error"><?= e($errors['syarat']) ?></div>
                        <?php endif; ?>
                        <button class="btn btn-primary btn-full" type="submit">Daftar</button>
                    </form>
                    <div class="login-foot">Sudah punya akun? <a href="login.php">Masuk di sini</a></div>
                </div>
            </div>
        </section>
    </main>
    <?php require __DIR__ . '/../../../app/views/partials/footer.php'; ?>
</body>

</html>