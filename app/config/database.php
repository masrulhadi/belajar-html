<?php
return [
    'host'     => getenv('DB_HOST') ?: 'db',
    'port'     => (int)(getenv('DB_PORT') ?: 3306),
    'database' => getenv('DB_NAME') ?: 'db_belajar_php',
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_ROOT_PASSWORD') ?: '',
    'charset'  => 'utf8mb4',
];
