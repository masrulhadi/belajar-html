<?php
declare(strict_types=1);

require_once __DIR__ . '/src/Env.php';

// Fallback: parse .env root jika container tidak meng-inject (dev lokal)
\App\Env::load(__DIR__ . '/../.env');

$appConfig = require __DIR__ . '/config/app.php';
$dbConfig  = require __DIR__ . '/config/database.php';

// Error handling
if ($appConfig['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
    ini_set('display_errors', '0');
}
ini_set('log_errors', '1');
ini_set('error_log', 'php://stderr');

set_error_handler(static function (int $severity, string $message, string $file, int $line): bool {
    if (!(error_reporting() & $severity)) {
        return false;
    }
    error_log(sprintf('[PHP %d] %s in %s:%d', $severity, $message, $file, $line));
    return false;
});
set_exception_handler(static function (\Throwable $e) use ($appConfig): void {
    error_log(sprintf('[EXC] %s in %s:%d', $e->getMessage(), $e->getFile(), $e->getLine()));
    if ($appConfig['debug']) {
        http_response_code(500);
        echo '<pre>' . htmlspecialchars($e->__toString(), ENT_QUOTES, 'UTF-8') . '</pre>';
    } else {
        http_response_code(500);
        echo 'Terjadi kesalahan pada server. Silakan coba lagi nanti.';
    }
    exit;
});

// Autoload sederhana (PSR-4 App\)
spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require_once $file;
    }
});

// Simpan config ke global supaya helper bisa akses
$GLOBALS['app_config'] = $appConfig;
$GLOBALS['db_config']  = $dbConfig;

// Session aman
\App\Session::start($appConfig);

// Header keamanan
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: SAMEORIGIN');
header('Referrer-Policy: strict-origin-when-cross-origin');

// Helpers
require_once __DIR__ . '/src/helpers.php';
