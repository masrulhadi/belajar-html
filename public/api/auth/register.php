<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../app/bootstrap.php';

if (!is_post()) {
    http_response_code(405);
    exit;
}
if (!\App\Csrf::verify($_POST['_token'] ?? null)) {
    \App\Flash::put(['_global' => 'Sesi kedaluwarsa, coba lagi.']);
    \App\Redirect::to(base_url('/pages/auth/register.php'));
}

$data = [
    'nama'             => trim((string)($_POST['nama'] ?? '')),
    'email'            => trim((string)($_POST['email'] ?? '')),
    'password'         => (string)($_POST['password'] ?? ''),
    'confirm-password' => (string)($_POST['confirm-password'] ?? ''),
    'syarat'           => (string)($_POST['syarat'] ?? ''),
];
$errors = \App\Validator::register($data);
if ($errors) {
    \App\Flash::put($errors, [
        'nama'  => $data['nama'],
        'email' => $data['email'],
    ]);
    \App\Redirect::to(base_url('/pages/auth/register.php'));
}

// duplicate email check
try {
    $pdo = \App\Database::connection();
    $stmt = $pdo->prepare('SELECT 1 FROM users WHERE LOWER(email) = LOWER(?) LIMIT 1');
    $stmt->execute([$data['email']]);
    if ($stmt->fetchColumn()) {
        \App\Flash::put(['email' => 'Email sudah terdaftar.'], [
            'nama'  => $data['nama'],
            'email' => $data['email'],
        ]);
        \App\Redirect::to(base_url('/pages/auth/register.php'));
    }
    $user = \App\Auth::register([
        'name'     => $data['nama'],
        'email'    => $data['email'],
        'password' => $data['password'],
    ]);
} catch (\PDOException $e) {
    if ($e->getCode() === '23000') {
        \App\Flash::put(['email' => 'Email sudah terdaftar.'], [
            'nama'  => $data['nama'],
            'email' => $data['email'],
        ]);
        \App\Redirect::to(base_url('/pages/auth/register.php'));
    }
    throw $e;
}

// auto-login
\App\Session::regenerate();
$_SESSION['user'] = [
    'id'    => (int)$user['id'],
    'name'  => $user['name'],
    'email' => $user['email'],
    'role'  => $user['role'],
];
\App\Csrf::rotate();
\App\Flash::put([], [], 'Akun berhasil dibuat. Selamat datang!');
\App\Redirect::to(base_url('/pages/auth/dashboard.php'));
