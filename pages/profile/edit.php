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

$errors = [];
$nama = $user['nama'];
$telepon = $user['telepon'] ?? '';
$bio = $user['bio'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');
    $bio = trim($_POST['bio'] ?? '');

    // Validasi Sisi Server
    if (empty($nama)) {
        $errors[] = 'Nama lengkap tidak boleh kosong.';
    }

    if (empty($errors)) {
        $koneksi = get_db();
        // Update data pengguna (Update - CRUD)
        $stmt = mysqli_prepare($koneksi, "UPDATE users SET nama = ?, telepon = ?, bio = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'sssi', $nama, $telepon, $bio, $user['id']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        set_flash_message('success', 'Data profil berhasil diperbarui.');
        header('Location: index.php');
        exit;
    }
}

$page_title = 'Edit Profil';
$current_page = 'profile';
$base_url = '../../';
require_once APP_ROOT . '/includes/header.php';
?>

<main style="padding: 40px 0 80px;">
    <div class="container" style="max-width: 640px;">
        <div style="margin-bottom: 24px;">
            <a href="index.php" class="text-link" style="font-weight: 700; font-size: 13px;">← Kembali ke Profil</a>
            <h1 style="margin: 12px 0 4px; font-size: 26px;">Edit Informasi Profil</h1>
            <p class="muted" style="margin: 0;">Perbarui data diri yang akan ditampilkan pada akunmu.</p>
        </div>

        <div class="login-card" style="box-shadow: var(--shadow);">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $err): ?>
                        <div>• <?= e($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="edit.php" method="POST">
                <label for="email_static">Alamat Email (Tidak dapat diubah)</label>
                <input type="email" id="email_static" value="<?= e($user['email']) ?>" disabled 
                    style="background: #f3f4f6; color: #6b7280; cursor: not-allowed;">

                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="<?= e($nama) ?>" required
                    style="width: 100%; min-height: 45px; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px;">

                <label for="telepon">Nomor Telepon / WhatsApp</label>
                <input type="tel" id="telepon" name="telepon" value="<?= e($telepon) ?>" placeholder="Contoh: 081234567890"
                    style="width: 100%; min-height: 45px; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px;">

                <label for="bio">Bio / Minat Belajar</label>
                <textarea id="bio" name="bio" rows="4" placeholder="Ceritakan sedikit tentang dirimu atau fokus belajarmu..."
                    style="width: 100%; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px; font-family: inherit; resize: vertical;"><?= e($bio) ?></textarea>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Simpan Perubahan</button>
                    <a href="index.php" class="btn btn-outline" style="text-align: center;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
