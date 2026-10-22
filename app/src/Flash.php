<?php
namespace App;

class Flash
{
    public static function put(array $errors = [], array $old = [], ?string $success = null): void
    {
        $_SESSION['_flash'] = [
            'errors'  => $errors,
            'old'     => $old,
            'success' => $success,
        ];
    }

    public static function pull(): array
    {
        $data = $_SESSION['_flash'] ?? ['errors' => [], 'old' => [], 'success' => null];
        unset($_SESSION['_flash']);
        return $data;
    }
}
