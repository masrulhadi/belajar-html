# Database Belajar HTML

## Struktur

- `migrations/` — file SQL idempotent (`CREATE TABLE IF NOT EXISTS`) per perubahan skema.
- Skema otomatis dijalankan saat container MySQL pertama kali dibuat
  (disalin ke `docker/mysql/init/001_schema.sql`).

## Menjalankan Migrasi Manual

```bash
# lewat CLI di dalam container web
docker compose exec web php /var/www/app/migrate.php

# atau lewat phpMyAdmin (http://localhost:8081) -> Import -> pilih file .sql
```

## Reset Database

```bash
docker compose down -v      # hapus volume (data hilang)
docker compose up -d        # volume baru, init script berjalan lagi
```

## Tabel

| Tabel | Fungsi |
|--------|--------|
| `users` | Akun pengguna (password disimpan sebagai hash bcrypt) |
| `login_attempts` | Riwayat percobaan login untuk rate limiting |
| `schema_migrations` | Daftar migrasi yang sudah diterapkan |
