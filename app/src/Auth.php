<?php
namespace App;

use PDO;

class Auth
{
    public static function register(array $data): array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare(
            'INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)'
        );
        $stmt->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
        ]);
        $id = (int)$pdo->lastInsertId();
        return self::find($id);
    }

    public static function attempt(string $email, string $password, bool $remember): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE LOWER(email) = LOWER(?) AND is_active = 1 LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if (!$user || !password_verify($password, $user['password_hash'])) {
            return null;
        }
        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            $pdo->prepare('UPDATE users SET password_hash = ? WHERE id = ?')
                ->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        }

        Session::regenerate();
        $_SESSION['user'] = [
            'id'    => (int)$user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];
        $pdo->prepare('UPDATE users SET last_login_at = NOW() WHERE id = ?')->execute([$user['id']]);

        if ($remember) {
            self::issueRememberToken((int)$user['id']);
        }
        Csrf::rotate();
        return $user;
    }

    public static function logout(): void
    {
        $user = $_SESSION['user'] ?? null;
        if (is_array($user) && isset($user['id'])) {
            $pdo = Database::connection();
            $pdo->prepare('UPDATE users SET remember_token = NULL, remember_token_expires = NULL WHERE id = ?')
                ->execute([(int)$user['id']]);
        }
        // hapus cookie remember
        if (isset($_COOKIE['remember_token'])) {
            $params = session_get_cookie_params();
            setcookie('remember_token', '', [
                'expires'  => time() - 42000,
                'path'     => '/',
                'domain'   => '',
                'secure'   => $params['secure'],
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }
        Session::destroy();
        Csrf::rotate();
    }

    public static function user(): ?array
    {
        if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        // auto-login via remember cookie
        $cookie = $_COOKIE['remember_token'] ?? null;
        if (!is_string($cookie) || !str_contains($cookie, '.')) {
            return null;
        }
        [$selector, $validator] = explode('.', $cookie, 2);
        if ($selector === '' || $validator === '') {
            return null;
        }
        $pdo = Database::connection();
        // Yang disimpan di DB hanya SHA-256 dari (selector.validator), bukan token mentah.
        // Token mentah tidak pernah menyentuh database, dan pencocokan memakai
        // perbandingan index yang bersifat constant-time.
        $hash = hash('sha256', $selector . '.' . $validator);
        $stmt = $pdo->prepare(
            'SELECT * FROM users WHERE remember_token = ? AND remember_token_expires > NOW() AND is_active = 1 LIMIT 1'
        );
        $stmt->execute([$hash]);
        $user = $stmt->fetch();
        if (!$user) {
            return null;
        }
        Session::regenerate();
        $_SESSION['user'] = [
            'id'    => (int)$user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role'],
        ];
        Csrf::rotate();
        return $_SESSION['user'];
    }

    public static function check(): bool
    {
        return self::user() !== null;
    }

    public static function find(int $id): ?array
    {
        $pdo = Database::connection();
        $stmt = $pdo->prepare('SELECT id,name,email,role,created_at,last_login_at FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    private static function issueRememberToken(int $userId): void
    {
        $selector  = bin2hex(random_bytes(6));
        $validator = bin2hex(random_bytes(32));
        $hash      = hash('sha256', $selector . '.' . $validator);
        $days = (int)($GLOBALS['app_config']['remember_days'] ?? 30);
        $expires = date('Y-m-d H:i:s', time() + $days * 86400);
        $pdo = Database::connection();
        $pdo->prepare('UPDATE users SET remember_token = ?, remember_token_expires = ? WHERE id = ?')
            ->execute([$hash, $expires, $userId]);
        $secure = str_starts_with((string)($GLOBALS['app_config']['url'] ?? ''), 'https://');
        setcookie('remember_token', $selector . '.' . $validator, [
            'expires'  => time() + $days * 86400,
            'path'     => '/',
            'domain'   => '',
            'secure'   => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    }
}
