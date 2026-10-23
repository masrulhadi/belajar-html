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
$goal_id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

$db = get_db();

// Ambil data target dan pastikan milik user yang sedang login
$stmt = $db->prepare("SELECT * FROM learning_goals WHERE id = ? AND user_id = ? LIMIT 1");
$stmt->execute([$goal_id, $user['id']]);
$goal = $stmt->fetch();

if (!$goal) {
    set_flash_message('danger', 'Data target belajar tidak ditemukan atau Anda tidak memiliki akses.');
    header('Location: ../profile/index.php');
    exit;
}

// Proses Hapus saat formulir dikirim via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmtDelete = $db->prepare("DELETE FROM learning_goals WHERE id = ? AND user_id = ?");
    $stmtDelete->execute([$goal_id, $user['id']]);

    set_flash_message('success', 'Target belajar "' . $goal['judul'] . '" berhasil dihapus.');
    header('Location: ../profile/index.php');
    exit;
}

$page_title = 'Hapus Target Belajar';
$current_page = 'profile';
$base_url = '../../';
require_once APP_ROOT . '/includes/header.php';
?>

<main style="padding: 40px 0 80px;">
    <div class="container" style="max-width: 540px;">
        <div style="margin-bottom: 24px;">
            <a href="../profile/index.php" class="text-link" style="font-weight: 700; font-size: 13px;">← Kembali ke Profil</a>
        </div>

        <div class="login-card" style="box-shadow: var(--shadow); border-top: 4px solid #e02424;">
            <div style="font-size: 38px; margin-bottom: 12px;">⚠️</div>
            <h1 style="margin: 0 0 8px; font-size: 22px; color: #9b1c1c;">Konfirmasi Hapus Data</h1>
            <p class="muted" style="margin: 0 0 20px;">Tindakan ini tidak dapat dibatalkan. Apakah Anda yakin ingin menghapus data target belajar ini?</p>

            <div style="background: #f9fafb; border: 1px solid var(--line); border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                <div style="font-size: 11px; color: var(--muted); text-transform: uppercase; font-weight: 700;">Judul Target</div>
                <div style="font-size: 16px; font-weight: 700; color: var(--navy); margin-top: 2px;">
                    <?= e($goal['judul']) ?>
                </div>

                <div style="display: flex; gap: 14px; margin-top: 10px; font-size: 12px; color: var(--muted);">
                    <div>Kategori: <strong><?= e($goal['kategori']) ?></strong></div>
                    <div>Status: <strong><?= e($goal['status']) ?></strong></div>
                </div>
            </div>

            <!-- Form Penghapusan Data (POST) Tanpa JavaScript -->
            <form action="delete.php?id=<?= $goal_id ?>" method="POST">
                <input type="hidden" name="id" value="<?= $goal_id ?>">
                <div style="display: flex; gap: 12px;">
                    <button type="submit" class="btn btn-danger" style="flex: 1;">
                        🗑️ Ya, Hapus Sekarang
                    </button>
                    <a href="../profile/index.php" class="btn btn-outline" style="text-align: center;">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
