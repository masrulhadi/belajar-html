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
$judul = '';
$kategori = 'HTML';
$status = 'Belum Dimulai';
$catatan = '';

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
        $koneksi = get_db();
        // Insert data baru (Create - CRUD)
        $stmt = mysqli_prepare($koneksi, "INSERT INTO learning_goals (user_id, judul, kategori, status, catatan) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'issss', $user['id'], $judul, $kategori, $status, $catatan);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        set_flash_message('success', 'Target belajar baru berhasil ditambahkan!');
        header('Location: ../profile/index.php');
        exit;
    }
}

$page_title = 'Tambah Target Belajar';
$current_page = 'profile';
$base_url = '../../';
require_once APP_ROOT . '/includes/header.php';
?>

<main style="padding: 40px 0 80px;">
    <div class="container" style="max-width: 640px;">
        <div style="margin-bottom: 24px;">
            <a href="../profile/index.php" class="text-link" style="font-weight: 700; font-size: 13px;">← Kembali ke Profil</a>
            <h1 style="margin: 12px 0 4px; font-size: 26px;">Tambah Target Belajar Baru</h1>
            <p class="muted" style="margin: 0;">Buat target materi atau keterampilan baru yang ingin kamu pelajari.</p>
        </div>

        <div class="login-card" style="box-shadow: var(--shadow);">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $err): ?>
                        <div>• <?= e($err) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form action="add.php" method="POST">
                <label for="judul">Judul Target Belajar *</label>
                <input type="text" id="judul" name="judul" value="<?= e($judul) ?>" placeholder="Misal: Mempelajari CSS Grid dan Flexbox" required
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
                        <label for="status" style="display: block; margin-bottom: 6px; font-size: 12px; font-weight: 750;">Status Awal</label>
                        <select id="status" name="status" style="width: 100%; min-height: 45px; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px; font-family: inherit;">
                            <option value="Belum Dimulai" <?= $status === 'Belum Dimulai' ? 'selected' : '' ?>>Belum Dimulai</option>
                            <option value="Sedang Belajar" <?= $status === 'Sedang Belajar' ? 'selected' : '' ?>>Sedang Belajar</option>
                            <option value="Selesai" <?= $status === 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                </div>

                <label for="catatan" style="display: block; margin-top: 14px; margin-bottom: 6px; font-size: 12px; font-weight: 750;">Catatan Tambahan (Opsional)</label>
                <textarea id="catatan" name="catatan" rows="3" placeholder="Tulis catatan atau referensi modul materi..."
                    style="width: 100%; padding: 11px 12px; border: 1px solid #dce2ef; border-radius: 10px; background: #fbfcff; font-size: 13px; font-family: inherit; resize: vertical;"><?= e($catatan) ?></textarea>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">+ Simpan Target Belajar</button>
                    <a href="../profile/index.php" class="btn btn-outline" style="text-align: center;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
