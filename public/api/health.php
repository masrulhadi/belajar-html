<?php
declare(strict_types=1);
require_once __DIR__ . '/../../app/bootstrap.php';

header('Content-Type: application/json; charset=utf-8');
$status = 'down';
try {
    \App\Database::connection()->query('SELECT 1');
    $status = 'up';
} catch (\Throwable $e) {
    $status = 'down';
}
echo json_encode([
    'status' => 'ok',
    'db'     => $status,
    'php'    => PHP_VERSION,
], JSON_UNESCAPED_SLASHES);
