<?php
define('APP_ROOT', dirname(__DIR__, 2));
require_once APP_ROOT . '/config/db.php';

// Jika sudah login, langsung arahkan ke profile
if (is_logged_in()) {
    header('Location: ../profile/index.php');
    exit;
}

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Email dan password wajib diisi.';
    } else {
        $koneksi = get_db();
        $stmt = mysqli_prepare($koneksi, "SELECT id, nama, email, password FROM users WHERE email = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password'])) {
            // Password cocok! Buat sesi login
            $_SESSION['user_id'] = (int)$user['id'];
            set_flash_message('success', 'Selamat datang kembali, ' . $user['nama'] . '!');

            // Pola Post/Redirect/Get ke halaman profile
            header('Location: ../profile/index.php');
            exit;
        } else {
            $error = 'Email atau password yang Anda masukkan tidak sesuai.';
        }
    }
}

$page_title = 'Masuk Akun';
$current_page = 'login';
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
                <span class="eyebrow"><span class="eyebrow-dot"></span> SELAMAT DATANG KEMBALI</span>
                <h1>Teruskan perjalanan <span class="text-yellow">belajarmu.</span></h1>
                <p>Masuk untuk mengelola target belajar, riwayat materi, dan profil akunmu.</p>
                <div class="login-benefit">Akses materi dan program belajar</div>
                <div class="login-benefit">Kelola progres belajar (CRUD)</div>
                <div class="login-benefit">Sesi aman dengan enkripsi kata sandi</div>
            </div>

            <div class="login-card">
                <h2>Masuk ke akun</h2>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger" style="margin-top: 12px;">
                        <span><?= e($error) ?></span>
                    </div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="nama@email.com"
                        value="<?= e($email) ?>" autocomplete="email" required>

                    <label for="password">Password</label>
                    <div class="password-wrap">
                        <input type="password" id="password" name="password"
                            placeholder="Masukkan password" autocomplete="current-password" required>
                    </div>

                    <div class="form-row">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember"> Ingat saya
                        </label>
                    </div>

                    <button class="btn btn-primary btn-full" type="submit">Masuk</button>
                </form>

                <div class="login-foot">
                    Belum punya akun? <a href="register.php">Daftar di sini</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
