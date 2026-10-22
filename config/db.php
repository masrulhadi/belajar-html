<?php
/**
 * Konfigurasi Database PDO & Session Helper
 * Proyek: Belajar HTML & CRUD PHP (Zero JS)
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Mendapatkan koneksi PDO ke MySQL
 */
function get_db(): PDO {
    static $pdo = null;

    if ($pdo === null) {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3306';
        $dbname = getenv('DB_NAME') ?: 'db_belajar_php';
        $user = getenv('DB_USER') ?: 'root';
        $pass = getenv('DB_ROOT_PASSWORD') ?: 'rahasia123';

        // Baca dari file .env jika getenv kosong (misal di lingkungan non-docker lokal)
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (strpos($line, '=') !== false) {
                    [$k, $v] = explode('=', $line, 2);
                    $k = trim($k);
                    $v = trim($v);
                    if ($k === 'DB_HOST' && empty(getenv('DB_HOST'))) $host = $v;
                    if ($k === 'DB_PORT' && empty(getenv('DB_PORT'))) $port = $v;
                    if ($k === 'DB_NAME' && empty(getenv('DB_NAME'))) $dbname = $v;
                    if ($k === 'DB_USER' && empty(getenv('DB_USER'))) $user = $v;
                    if ($k === 'DB_ROOT_PASSWORD' && empty(getenv('DB_ROOT_PASSWORD'))) $pass = $v;
                }
            }
        }

        $dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8'));
        }
    }

    return $pdo;
}

/**
 * Cek apakah user sedang login
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Ambil ID user yang sedang login
 */
function get_logged_in_user_id(): ?int {
    return is_logged_in() ? (int)$_SESSION['user_id'] : null;
}

/**
 * Ambil data user yang sedang login dari database
 */
function get_current_user_data(): ?array {
    $userId = get_logged_in_user_id();
    if (!$userId) return null;

    $db = get_db();
    $stmt = $db->prepare("SELECT id, nama, email, bio, telepon, created_at FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    return $user ?: null;
}

/**
 * Wajibkan login untuk mengakses halaman tertentu
 */
function require_login(string $redirectPath = 'auth/login.php'): void {
    if (!is_logged_in()) {
        set_flash_message('warning', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        header("Location: {$redirectPath}");
        exit;
    }
}

/**
 * Set flash message (notifikasi satu kali tampil)
 */
function set_flash_message(string $type, string $message): void {
    $_SESSION['flash'] = [
        'type' => $type, // 'success', 'danger', 'warning', 'info'
        'message' => $message
    ];
}

/**
 * Ambil flash message lalu bersihkan dari session
 */
function get_flash_message(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Sanitasi string untuk output HTML aman
 */
function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}
