<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../app/bootstrap.php';

if (!is_post()) {
    http_response_code(405);
    exit;
}
if (!\App\Csrf::verify($_POST['_token'] ?? null)) {
    \App\Flash::put(['_global' => 'Sesi kedaluwarsa, coba lagi.']);
    \App\Redirect::to(base_url('/pages/auth/login.php'));
}

$email = trim((string)($_POST['email'] ?? ''));
$password = (string)($_POST['password'] ?? '');
$remember = isset($_POST['remember']);

$errors = \App\Validator::login(['email' => $email, 'password' => $password]);
if ($errors) {
    \App\Flash::put($errors, ['email' => $email]);
    \App\Redirect::to(base_url('/pages/auth/login.php'));
}

$ip = client_ip();
if (\App\RateLimiter::isBlocked($email, $ip)) {
    \App\Flash::put(['_global' => 'Terlalu banyak percobaan login. Coba lagi nanti.'], ['email' => $email]);
    \App\Redirect::to(base_url('/pages/auth/login.php'));
}

$user = \App\Auth::attempt($email, $password, $remember);
\App\RateLimiter::record($email, $ip, $user !== null);

if ($user === null) {
    \App\Flash::put(['_global' => 'Email atau password salah.'], ['email' => $email]);
    \App\Redirect::to(base_url('/pages/auth/login.php'));
}

\App\Flash::put([], [], 'Berhasil masuk. Selamat datang kembali!');
\App\Redirect::to(base_url('/pages/auth/dashboard.php'));
