<?php
namespace App;

class Validator
{
    public static function register(array $data): array
    {
        $errors = [];
        $name = trim((string)($data['nama'] ?? ''));
        $email = trim((string)($data['email'] ?? ''));
        $pw = (string)($data['password'] ?? '');
        $confirm = (string)($data['confirm-password'] ?? '');
        $syarat = (string)($data['syarat'] ?? '');

        if (mb_strlen($name) < 3 || mb_strlen($name) > 100) {
            $errors['nama'] = 'Nama harus 3-100 karakter.';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 191) {
            $errors['email'] = 'Email tidak valid.';
        }
        if (mb_strlen($pw) < 8 || mb_strlen($pw) > 72) {
            $errors['password'] = 'Password harus 8-72 karakter.';
        } elseif (!preg_match('/[A-Za-z]/', $pw) || !preg_match('/[0-9]/', $pw)) {
            $errors['password'] = 'Password harus mengandung huruf dan angka.';
        }
        if ($confirm !== $pw) {
            $errors['confirm-password'] = 'Konfirmasi password tidak cocok.';
        }
        if ($syarat !== 'on') {
            $errors['syarat'] = 'Anda harus menyetujui syarat & ketentuan.';
        }
        return $errors;
    }

    public static function login(array $data): array
    {
        $errors = [];
        $email = trim((string)($data['email'] ?? ''));
        $pw = (string)($data['password'] ?? '');
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email tidak valid.';
        }
        if ($pw === '') {
            $errors['password'] = 'Password wajib diisi.';
        }
        return $errors;
    }
}
