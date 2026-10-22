<?php
define('APP_ROOT', dirname(__DIR__, 2));
require_once APP_ROOT . '/config/db.php';

// Jika sudah login, langsung arahkan ke profile
if (is_logged_in()) {
    header('Location: ../profile.php');
    exit;
}

$errors = [];
$nama = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm-password'] ?? '';
    $syarat = isset($_POST['syarat']);

    // Validasi Sisi Server (PHP)
    if (empty($nama)) {
        $errors[] = 'Nama lengkap wajib diisi.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid.';
    }
    if (strlen($password) < 8) {
        $errors[] = 'Password minimal harus 8 karakter.';
    }
    if ($password !== $confirm_password) {
        $errors[] = 'Konfirmasi password tidak sesuai.';
    }
    if (!$syarat) {
        $errors[] = 'Anda harus menyetujui syarat & ketentuan.';
    }

    if (empty($errors)) {
        $db = get_db();

        // Cek apakah email sudah terdaftar
        $stmtCheck = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmtCheck->execute([$email]);
        if ($stmtCheck->fetch()) {
            $errors[] = 'Email sudah digunakan. Silakan gunakan email lain atau masuk.';
        } else {
            // Hash password secara aman dengan BCRYPT
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Simpan pengguna baru ke database (Create)
            $stmtInsert = $db->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
            $stmtInsert->execute([$nama, $email, $hashedPassword]);

            $newUserId = (int)$db->lastInsertId();

            // Berikan 1 contoh target belajar awal agar halaman profil langsung memiliki data
            $stmtGoal = $db->prepare("INSERT INTO learning_goals (user_id, judul, kategori, status, catatan) VALUES (?, ?, ?, ?, ?)");
            $stmtGoal->execute([
                $newUserId,
                'Mempelajari Dasar Web (HTML, CSS, PHP)',
                'PHP',
                'Sedang Belajar',
                'Target awal setelah berhasil mendaftar akun baru.'
            ]);

            // Set sesi login
            $_SESSION['user_id'] = $newUserId;
            set_flash_message('success', 'Akun berhasil dibuat! Selamat datang di profil belajarmu.');

            // Pola Post/Redirect/Get
            header('Location: ../profile.php');
            exit;
        }
    }
}

$page_title = 'Daftar Akun Baru';
$current_page = 'register';
$base_url = '../../';
require_once APP_ROOT . '/includes/header.php';
?>

<main>
    <section class="login-section">
        <div class="container login-layout">
            <div class="login-intro">
                <a class="brand brand-login" href="../../index.php">
                    <span class="brand-mark">D</span>
                    <span>Belajar<span class="brand-accent">HTML</span></span>
                </a>
                <span class="eyebrow"><span class="eyebrow-dot"></span> BUAT AKUN BARU</span>
                <h1>Mulai perjalanan <span class="text-yellow">belajarmu.</span></h1>
                <p>Daftar akun gratis untuk mengelola target belajar dan progres kursusmu.</p>
                <div class="login-benefit">✓ Akses semua materi dan course</div>
                <div class="login-benefit">✓ Kelola target &amp; roadmap belajarmu</div>
                <div class="login-benefit">✓ Data tersimpan aman di database MySQL</div>
            </div>

            <div class="login-card">
                <h2>Daftar akun baru</h2>
                <p class="muted">Isi data berikut untuk membuat akunmu.</p>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger" style="margin-top: 15px;">
                        <div>
                            <?php foreach ($errors as $err): ?>
                                <div>• <?= e($err) ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form action="register.php" method="POST" class="static-login-form">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap"
                        value="<?= e($nama) ?>" autocomplete="name" required>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nama@email.com"
                        value="<?= e($email) ?>" autocomplete="email" required>

                    <label for="password">Password</label>
                    <div class="password-wrap">
                        <input type="password" id="password" name="password"
                            placeholder="Buat password (min. 8 karakter)" minlength="8"
                            autocomplete="new-password" required>
                    </div>

                    <label for="confirm-password">Konfirmasi Password</label>
                    <div class="password-wrap">
                        <input type="password" id="confirm-password" name="confirm-password"
                            placeholder="Ulangi password" minlength="8"
                            autocomplete="new-password" required>
                    </div>

                    <div class="form-row">
                        <label class="checkbox-label">
                            <input type="checkbox" name="syarat" required>
                            Saya setuju dengan <a href="#" class="text-link">syarat &amp; ketentuan</a>
                        </label>
                    </div>

                    <button class="btn btn-primary btn-full" type="submit">Daftar Sekarang</button>
                </form>

                <div class="login-foot">
                    Sudah punya akun? <a href="login.php">Masuk di sini</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
