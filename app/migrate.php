<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

$pdo = \App\Database::connection();
$pdo->exec('CREATE TABLE IF NOT EXISTS schema_migrations (
  filename VARCHAR(191) NOT NULL PRIMARY KEY,
  applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

$files = glob(__DIR__ . '/../database/migrations/*.sql');
sort($files);
foreach ($files as $file) {
    $name = basename($file);
    $stmt = $pdo->prepare('SELECT 1 FROM schema_migrations WHERE filename = ?');
    $stmt->execute([$name]);
    if ($stmt->fetchColumn()) {
        echo "skip  $name\n";
        continue;
    }
    $sql = file_get_contents($file);
    $pdo->exec($sql);
    $pdo->prepare('INSERT INTO schema_migrations (filename) VALUES (?)')->execute([$name]);
    echo "apply $name\n";
}
echo "done\n";
