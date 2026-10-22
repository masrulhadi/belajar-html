<?php
return [
    'env'             => getenv('APP_ENV') ?: 'local',
    'debug'           => filter_var(getenv('APP_DEBUG') ?: 'false', FILTER_VALIDATE_BOOLEAN),
    'url'             => rtrim(getenv('APP_URL') ?: 'http://localhost:8080', '/'),
    'base_path'       => getenv('BASE_PATH') ?: '/',
    'session_name'    => getenv('SESSION_NAME') ?: 'belajarhtml_sess',
    'session_lifetime'=> (int)(getenv('SESSION_LIFETIME') ?: 7200),
    'remember_days'   => (int)(getenv('REMEMBER_DAYS') ?: 30),
    'login_max'       => (int)(getenv('LOGIN_MAX_ATTEMPTS') ?: 5),
    'login_lockout'   => (int)(getenv('LOGIN_LOCKOUT_MINUTES') ?: 15),
];
