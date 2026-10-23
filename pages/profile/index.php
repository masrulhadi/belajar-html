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

$db = get_db();

// Ambil daftar target belajar milik pengguna (Read - CRUD)
$stmt = $db->prepare("SELECT * FROM learning_goals WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$user['id']]);
$goals = $stmt->fetchAll();

// Inisial avatar
$initial = strtoupper(substr(trim($user['nama']), 0, 1));

$page_title = 'Profil Saya';
$current_page = 'profile';
$base_url = '../../';
require_once APP_ROOT . '/includes/header.php';
?>

<main style="padding: 40px 0 80px;">
    <div class="container">
        <!-- Header Halaman Profil -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; margin-bottom: 24px; border-bottom: 1px solid var(--line); padding-bottom: 20px;">
            <div>
                <span class="eyebrow"><span class="eyebrow-dot"></span> DASHBOARD PENGGUNA</span>
                <h1 style="margin: 4px 0 0; font-size: 28px;">Halo, <span class="text-yellow"><?= e($user['nama']) ?></span>!</h1>
                <p class="muted" style="margin: 4px 0 0;">Kelola data profil dan pantau target belajarmu di sini.</p>
            </div>
            <div>
                <a href="../goals/add.php" class="btn btn-primary btn-small">+ Tambah Target Belajar</a>
            </div>
        </div>

        <!-- Layout Grid Profil & CRUD -->
        <div class="profile-layout-grid">
            <!-- Sisi Kiri: Kartu Profil (Read User) -->
            <aside>
                <div class="profile-card">
                    <div class="profile-avatar">
                        <?= $initial ?>
                    </div>
                    <h2 style="font-size: 20px; margin: 0 0 4px;"><?= e($user['nama']) ?></h2>
                    <p class="muted" style="margin: 0 0 18px; word-break: break-all;"><?= e($user['email']) ?></p>

                    <div class="profile-meta-item">
                        <div class="profile-meta-label">Nomor Telepon</div>
                        <div class="profile-meta-val"><?= !empty($user['telepon']) ? e($user['telepon']) : '<span style="color:#9ca3af;font-weight:400;">Belum diatur</span>' ?></div>
                    </div>

                    <div class="profile-meta-item">
                        <div class="profile-meta-label">Bio / Minat</div>
                        <div class="profile-meta-val" style="line-height: 1.5; font-size: 13px;">
                            <?= !empty($user['bio']) ? nl2br(e($user['bio'])) : '<span style="color:#9ca3af;font-weight:400;">Belum ada biodata singkat.</span>' ?>
                        </div>
                    </div>

                    <div class="profile-meta-item">
                        <div class="profile-meta-label">Bergabung Sejak</div>
                        <div class="profile-meta-val" style="font-size: 12px; color: var(--muted);">
                            <?= date('d M Y, H:i', strtotime($user['created_at'])) ?>
                        </div>
                    </div>

                    <hr style="border: 0; border-top: 1px solid var(--line); margin: 20px 0;">

                    <!-- Tombol Aksi Profil -->
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <a href="edit.php" class="btn btn-outline btn-small" style="text-align: center; justify-content: center;">
                            ✏️ Edit Profil
                        </a>
                        <a href="delete.php" class="btn btn-small" style="background:#fff1f1; color:#c81e1e; border:1px solid #f8b4b4; text-align:center; justify-content:center;">
                            🗑️ Hapus Akun
                        </a>
                    </div>
                </div>
            </aside>

            <!-- Sisi Kanan: Tabel CRUD Target Belajar (Read Goals) -->
            <section>
                <div style="background: white; border: 1px solid var(--line); border-radius: 18px; padding: 24px; box-shadow: var(--shadow);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 10px;">
                        <div>
                            <h2 style="font-size: 20px; margin: 0;">Target &amp; Progres Belajar (CRUD)</h2>
                            <p class="muted" style="margin: 3px 0 0;">Total data: <?= count($goals) ?> target pembelajaran</p>
                        </div>
                        <a href="../goals/add.php" class="btn btn-outline btn-small">+ Buat Baru</a>
                    </div>

                    <?php if (empty($goals)): ?>
                        <div style="text-align: center; padding: 45px 20px; background: #fafbff; border-radius: 12px; border: 1px dashed var(--line);">
                            <div style="font-size: 36px; margin-bottom: 10px;">🎯</div>
                            <h3 style="margin: 0 0 6px; font-size: 16px;">Belum Ada Target Belajar</h3>
                            <p class="muted" style="margin: 0 0 16px;">Mulai buat rencana belajar pertamamu untuk melacak progres kursus dan materi.</p>
                            <a href="../goals/add.php" class="btn btn-primary btn-small">+ Tambah Sekarang</a>
                        </div>
                    <?php else: ?>
                        <div class="table-wrap">
                            <table class="path-table">
                                <thead>
                                    <tr>
                                        <th style="width: 45px; text-align: center;">No</th>
                                        <th>Target Belajar</th>
                                        <th style="width: 100px;">Kategori</th>
                                        <th style="width: 120px;">Status</th>
                                        <th>Catatan</th>
                                        <th style="width: 110px; text-align: center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($goals as $index => $g): ?>
                                        <tr>
                                            <td style="text-align: center; font-weight: 700; color: var(--muted);">
                                                <?= $index + 1 ?>
                                            </td>
                                            <td>
                                                <strong style="color: var(--navy);"><?= e($g['judul']) ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"><?= e($g['kategori']) ?></span>
                                            </td>
                                            <td>
                                                <?php if ($g['status'] === 'Selesai'): ?>
                                                    <span class="badge badge-success">✓ Selesai</span>
                                                <?php elseif ($g['status'] === 'Sedang Belajar'): ?>
                                                    <span class="badge badge-warning">⏳ Sedang</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Belum</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="font-size: 12px; color: #4b5563; max-width: 250px;">
                                                <?= !empty($g['catatan']) ? e($g['catatan']) : '<span style="color:#9ca3af;">-</span>' ?>
                                            </td>
                                            <td style="text-align: center;">
                                                <div class="table-actions" style="justify-content: center;">
                                                    <a href="../goals/edit.php?id=<?= $g['id'] ?>" class="action-btn-edit" title="Edit Data">Edit</a>
                                                    <span style="color: #d1d5db;">|</span>
                                                    <a href="../goals/delete.php?id=<?= $g['id'] ?>" class="action-btn-del" title="Hapus Data">Hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>
</main>

<?php require_once APP_ROOT . '/includes/footer.php'; ?>
