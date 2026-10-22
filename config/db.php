<?php
/**
 * Konfigurasi Database & Helper
 * Belajar HTML & CRUD PHP (Zero JS)
 */

// Mulai session jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi koneksi MySQL
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'db_belajar_php';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_ROOT_PASSWORD') ?: 'rahasia123';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi bantu mengambil objek PDO
function get_db() {
    global $pdo;
    return $pdo;
}

// Cek apakah user sedang login
function is_logged_in() {
    return !empty($_SESSION['user_id']);
}

// Ambil data user yang sedang login
function get_current_user_data() {
    if (!is_logged_in()) {
        return null;
    }
    
    $db = get_db();
    $stmt = $db->prepare("SELECT id, nama, email, bio, telepon, created_at FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch() ?: null;
}

// Wajibkan login untuk mengakses halaman privat
function require_login($redirect = 'auth/login.php') {
    if (!is_logged_in()) {
        set_flash_message('warning', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        header("Location: {$redirect}");
        exit;
    }
}

// Set notifikasi flash message
function set_flash_message($type, $message) {
    $_SESSION['flash'] = [
        'type'    => $type,
        'message' => $message
    ];
}

// Ambil flash message lalu bersihkan dari session
function get_flash_message() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

// Sanitasi output string agar aman dari XSS
function e($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
