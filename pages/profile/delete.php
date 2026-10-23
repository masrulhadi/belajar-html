<?php
define('APP_ROOT', dirname(__DIR__, 2));
require_once APP_ROOT . '/config/db.php';

// Wajib login
require_login('../auth/login.php');

$user = get_current_user_data();
if (!$user) {
    header('Location: ../auth/logout.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    if (empty($password)) {
        $error = 'Masukkan kata sandi Anda untuk mengonfirmasi penghapusan akun.';
    } else {
        $db = get_db();
        // Ambil password hash untuk verifikasi
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ? LIMIT 1");
        $stmt->execute([$user['id']]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['password'])) {
            // Hapus pengguna (Delete Akun)
            // Relasi foreign key ON DELETE CASCADE akan otomatis menghapus semua target belajar pengguna ini
            $stmtDel = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmtDel->execute([$user['id']]);

            // Bersihkan sesi login
            $_SESSION = [];
            session_destroy();

            session_start();
            set_flash_message('info', 'Akun dan seluruh data Anda telah berhasil dihapus secara permanen.');
            header('Location: ../auth/register.php');
            exit;
        } else {
            $error = 'Kata sandi yang Anda masukkan salah. Penghapusan akun dibatalkan.';
        }
    }
}

$page_title = 'Hapus Akun';
$current_page = 'profile';
$base_url = '../../';
require_once APP_ROOT . '/includes/header.php';
?>

<main style="padding: 40px 0 80px;">
    <div class="container" style="max-width: 540px;">
        <div style="margin-bottom: 24px;">
            <a href="index.php" class="text-link" style="font-weight: 700; font-size: 13px;">← Kembali ke Profil</a>
        </div>

        <div class="login-card" style="box-shadow: var(--shadow); border-top: 4px solid #e02424;">
            <div style="font-size: 38px; margin-bottom: 12px;">🚨</div>
            <h1 style="margin: 0 0 8px; font-size: 22px; color: #9b1c1c;">Hapus Akun Permanen</h1>
            <p class="muted" style="margin: 0 0 20px;">
                PERINGATAN: Tindakan ini bersifat permanen. Akun <strong><?= e($user['email']) ?></strong> beserta seluruh target pembelajaran akan dihapus secara total dari sistem.
            </p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" style="margin-bottom: 20px;">
                    <?= e($error) ?>
                </div>
            <?php endif; ?>

            <form action="delete.php" method="POST">
                <label for="password">Konfirmasi Kata Sandi Anda *</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password untuk verifikasi" required
                    style="width: 100%; min-height: 45px; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px;">

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-danger" style="flex: 1;">
                        Hapus Akun Saya
                    </button>
                    <a href="index.php" class="btn btn-outline" style="text-align: center;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
