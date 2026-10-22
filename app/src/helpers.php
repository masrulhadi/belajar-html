<?php
if (!function_exists('e')) {
    function e(mixed $value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
if (!function_exists('base_url')) {
    function base_url(string $path = ''): string
    {
        $cfg = $GLOBALS['app_config'] ?? [];
        $base = rtrim((string)($cfg['base_path'] ?? '/'), '/');
        $path = '/' . ltrim($path, '/');
        return $base . $path;
    }
}
if (!function_exists('old')) {
    function old(string $key, string $default = ''): string
    {
        $flash = $_SESSION['_flash'] ?? [];
        $old = is_array($flash['old'] ?? null) ? $flash['old'] : [];
        $val = $old[$key] ?? $default;
        return (string)$val;
    }
}
if (!function_exists('is_post')) {
    function is_post(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }
}
if (!function_exists('client_ip')) {
    function client_ip(): string
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        if (str_contains($ip, ',')) {
            $ip = trim(explode(',', $ip)[0]);
        }
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
    }
}
if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        return \App\Csrf::token();
    }
}
