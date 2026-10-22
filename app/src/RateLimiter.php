<?php
namespace App;

class RateLimiter
{
    public static function isBlocked(string $email, string $ip): bool
    {
        $app = $GLOBALS['app_config'];
        $max = (int)$app['login_max'];
        $lock = (int)$app['login_lockout'];
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'SELECT COUNT(*) FROM login_attempts
             WHERE email = ? AND ip_address = ? AND success = 0
               AND attempted_at > (NOW() - INTERVAL ? MINUTE)'
        );
        $stmt->execute([$email, $ip, $lock]);
        return (int)$stmt->fetchColumn() >= $max;
    }

    public static function record(string $email, string $ip, bool $success): void
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'INSERT INTO login_attempts (email, ip_address, success) VALUES (?, ?, ?)'
        );
        $stmt->execute([$email, $ip, $success ? 1 : 0]);
    }
}
