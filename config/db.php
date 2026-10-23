<?php

// Mulai session jika belum aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Muat variabel dari berkas .env (jika ada)
$envFile = dirname(__DIR__) . '/.env';
if (is_readable($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') {
            continue;
        }
        $pos = strpos($line, '=');
        if ($pos === false) {
            continue;
        }
        $key = trim(substr($line, 0, $pos));
        $value = trim(substr($line, $pos + 1));
        if ($key !== '' && getenv($key) === false) {
            putenv($key . '=' . $value);
        }
    }
}

// Konfigurasi koneksi MySQL (PDO)
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$db   = getenv('DB_NAME') ?: 'db_belajar_php';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_ROOT_PASSWORD');

if ($pass === false || $pass === '') {
    die('Konfigurasi database tidak lengkap. Salin .env.example menjadi .env lalu isi nilainya.');
}

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
    $stmt = $db->prepare("SELECT id, nama, email, bio, telepon, created_at FROM users WHERE id = ? LIMIT 1");
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
