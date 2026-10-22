<?php
declare(strict_types=1);
require_once __DIR__ . '/../../../app/bootstrap.php';

if (!is_post()) {
    http_response_code(405);
    exit;
}
if (!\App\Csrf::verify($_POST['_token'] ?? null)) {
    http_response_code(403);
    exit;
}
\App\Auth::logout();
\App\Flash::put([], [], 'Anda telah keluar.');
\App\Redirect::to(base_url('/pages/auth/login.php'));
