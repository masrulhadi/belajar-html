<?php
define('APP_ROOT', dirname(__DIR__, 2));
require_once APP_ROOT . '/config/db.php';

// Wajib login
require_login('../auth/login.php');

$user = get_current_user_data();
$goal_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$db = get_db();

// Ambil data target yang akan diedit dan pastikan milik user yang sedang login
$stmt = $db->prepare("SELECT * FROM learning_goals WHERE id = ? AND user_id = ? LIMIT 1");
$stmt->execute([$goal_id, $user['id']]);
$goal = $stmt->fetch();

if (!$goal) {
    set_flash_message('danger', 'Data target belajar tidak ditemukan atau Anda tidak memiliki akses.');
    header('Location: ../profile.php');
    exit;
}

$errors = [];
$judul = $goal['judul'];
$kategori = $goal['kategori'];
$status = $goal['status'];
$catatan = $goal['catatan'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? 'HTML');
    $status = trim($_POST['status'] ?? 'Belum Dimulai');
    $catatan = trim($_POST['catatan'] ?? '');

    // Validasi Sisi Server
    if (empty($judul)) {
        $errors[] = 'Judul target belajar wajib diisi.';
    }

    $valid_kategori = ['HTML', 'CSS', 'PHP', 'Database', 'Lainnya'];
    if (!in_array($kategori, $valid_kategori)) {
        $kategori = 'HTML';
    }

    $valid_status = ['Belum Dimulai', 'Sedang Belajar', 'Selesai'];
    if (!in_array($status, $valid_status)) {
        $status = 'Belum Dimulai';
    }

    if (empty($errors)) {
        // Update data target belajar (Update - CRUD)
        $stmtUpdate = $db->prepare("UPDATE learning_goals SET judul = ?, kategori = ?, status = ?, catatan = ? WHERE id = ? AND user_id = ?");
        $stmtUpdate->execute([$judul, $kategori, $status, $catatan, $goal_id, $user['id']]);

        set_flash_message('success', 'Target belajar berhasil diperbarui!');
        header('Location: ../profile.php');
        exit;
    }
}

$page_title = 'Edit Target Belajar';
$current_page = 'profile';
$base_url = '../../';
require_once APP_ROOT . '/includes/header.php';
?>

<main style="padding: 40px 0 80px;">
    <div class="container" style="max-width: 640px;">
        <div style="margin-bottom: 24px;">
            <a href="../profile.php" class="text-link" style="font-weight: 700; font-size: 13px;">← Kembali ke Profil</a>
            <h1 style="margin: 12px 0 4px; font-size: 26px;">Edit Target Belajar</h1>
            <p class="muted" style="margin: 0;">Perbarui progres atau rincian materi yang sedang kamu pelajari.</p>
        </div>

        <div class="login-card" style="box-shadow: var(--shadow);">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $err): ?>
                        <div>• <?= e($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="edit.php?id=<?= $goal_id ?>" method="POST">
                <label for="judul">Judul Target Belajar *</label>
                <input type="text" id="judul" name="judul" value="<?= e($judul) ?>" required
                    style="width: 100%; min-height: 45px; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px;">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 14px;">
                    <div>
                        <label for="kategori" style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 750;">Kategori</label>
                        <select id="kategori" name="kategori" style="width: 100%; min-height: 45px; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px; font-family: inherit;">
                            <option value="HTML" <?= $kategori === 'HTML' ? 'selected' : '' ?>>HTML</option>
                            <option value="CSS" <?= $kategori === 'CSS' ? 'selected' : '' ?>>CSS</option>
                            <option value="PHP" <?= $kategori === 'PHP' ? 'selected' : '' ?>>PHP</option>
                            <option value="Database" <?= $kategori === 'Database' ? 'selected' : '' ?>>Database (MySQL)</option>
                            <option value="Lainnya" <?= $kategori === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 750;">Status Belajar</label>
                        <select id="status" name="status" style="width: 100%; min-height: 45px; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px; font-family: inherit;">
                            <option value="Belum Dimulai" <?= $status === 'Belum Dimulai' ? 'selected' : '' ?>>Belum Dimulai</option>
                            <option value="Sedang Belajar" <?= $status === 'Sedang Belajar' ? 'selected' : '' ?>>Sedang Belajar</option>
                            <option value="Selesai" <?= $status === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                </div>

                <label for="catatan" style="display: block; margin-top: 14px; margin-bottom: 6px; font-size: 12px; font-weight: 750;">Catatan Tambahan</label>
                <textarea id="catatan" name="catatan" rows="3"
                    style="width: 100%; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px; font-family: inherit; resize: vertical;"><?= e($catatan) ?></textarea>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">Simpan Perubahan</button>
                    <a href="../profile.php" class="btn btn-outline" style="text-align: center;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
