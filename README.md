
# Laravel 12 Starter Kit

Ringkasan singkat: starter kit ini adalah kerangka kerja dasar untuk proyek Laravel 12 yang saya gunakan sehari-hari. Dokumen ini menjelaskan persyaratan, dependensi, struktur folder utama, konvensi penulisan kode, dan langkah-langkah setup & pengembangan.

## Isi cepat

- Laravel 12, PHP ^8.2
- Dependensi utama di-manage lewat `composer.json`
- Development tools: `laravel/pint`, `phpunit`, `sail` (opsional)
- Konvensi: PSR-12, Laravel conventions, dan Pint untuk formatting

## Persyaratan Sistem

- PHP 8.2+
- Composer (latest stable)
- Node.js & npm (untuk assets / Vite)
- SQLite (tersedia di repo sebagai `database/database.sqlite`) atau database lain (MySQL/Postgres)

## Instalasi (cepat)

1. Clone repository
2. Install PHP dependencies

```bash
composer install --prefer-dist --no-interaction
```

3. Install JS dependencies

```bash
npm install
```

4. Siapkan environment

```bash
cp .env.example .env
php artisan key:generate
```

Jika menggunakan SQLite (default repo):

```bash
touch database/database.sqlite
php artisan migrate --force
```

5. Jalankan dev server dan proses pendukung (opsional)

```bash
# menjalankan server, queue, logs watcher dan vite (lihat script "dev" di composer.json)
composer run-script dev
```

Atau secara manual:

```bash
php artisan serve
npm run dev
```

## Script composer penting

- `composer run-script dev` — menjalankan development supervisor (lihat `composer.json` untuk perintah lengkap)
- `composer test` — jalankan test suite via `php artisan test`

Daftar script lengkap ada di `composer.json`.

## Dependensi Composer (ringkasan)

Dependensi production (ringkasan dari `composer.json`):

- `laravel/framework` ^12.0
- `php` ^8.2
- `barryvdh/laravel-dompdf` — generate PDF
- `darkaonline/l5-swagger`, `zircote/swagger-php` — API docs
- `kra8/laravel-snowflake` — ID generator
- `lab404/laravel-impersonate` — impersonation
- `maatwebsite/excel` — Excel import/export
- `predis/predis` — Redis client (predis)
- `realrashid/sweet-alert` — sweet alert notifications
- `simplesoftwareio/simple-qrcode` — QR code generator
- `tymon/jwt-auth` — JWT auth
- `yajra/laravel-datatables-oracle` — server-side datatables
- `spatie/laravel-permission` — roles & permissions

Dependensi development (ringkasan):

- `fakerphp/faker` — test data
- `laravel/pint` — code formatter (Pint)
- `phpunit/phpunit` — unit/integration tests
- `nunomaduro/collision` — error handler for CLI
- `laravel/sail` — optional, docker local dev

Untuk daftar versi lengkap lihat `composer.json`.

## Autoload & Helpers

File helper yang di-autoload di `composer.json`:
- `app/Helpers/Utilities.php`
- `app/Helpers/Curl.php`

Namespace PSR-4:

- `App\` => `app/`
- `Database\Factories\` => `database/factories/`
- `Database\Seeders\` => `database/seeders/`

## Struktur folder utama (ringkasan dan peran)

Root project mengikuti konvensi Laravel. Beberapa folder penting:

- `app/` — kode aplikasi (Controllers, Models, Middleware, Providers, Traits, Helpers)
	- `app/Http/Controllers/` — controllers
	- `app/Models/` — Eloquent models (misal `User.php`)
	- `app/Providers/` — service providers
	- `app/Traits/` — trait yang dipakai lintas class (mis. `ApiResponse`)
	- `app/Utilities/` — utility classes (contoh: `Document.php`, `ReadExcel.php`)
- `bootstrap/` — bootstrap app & cached providers
- `config/` — konfigurasi aplikasi
- `database/` — migrations, factories, seeders, `database.sqlite`
- `public/` — web entry point dan assets yang disajikan
- `resources/` — views (Blade), JS, CSS (Vite)
- `routes/` — `web.php`, `api.php`, `console.php`
- `tests/` — unit & feature tests

Gunakan struktur standar Laravel: controllers di `Http/Controllers`, form requests di `Http/Requests` (jika dibuat), events/listeners, dan sebagainya.

## Konvensi Penulisan Kode (Code Style)

1. PSR-12 sebagai baseline style.
2. Gunakan `laravel/pint` untuk formatting otomatis. Jalankan sebelum commit:

```bash
./vendor/bin/pint --ansi
```

atau tambahkan ke pre-commit hook (opsional).

3. Naming conventions

- Controller: `PascalCase` diakhiri `Controller` (mis. `UserController`)
- Model: `PascalCase` (mis. `User`)
- Database migration: snake_case timestamp prefix (Laravel default)
- Route names: dot.notation (mis. `users.index`)
- Config keys: snake_case

4. Requests & Validation

- Gunakan Form Request classes (`php artisan make:request`) untuk validasi input and authorize logic.

5. Dependency injection

- Inject services via constructor injection pada controller atau method injection jika ringan.

6. Exception handling & API responses

- Untuk API gunakan trait `ApiResponse` (tersedia di `app/Traits/ApiResponse.php`) agar format konsisten.

7. Tests

- Tulis unit dan feature test menggunakan PHPUnit (`phpunit`) atau `php artisan test`.

## Cara menjalankan test

```bash
composer test
```

Kamu juga bisa menjalankan PHPUnit langsung:

```bash
./vendor/bin/phpunit
```

## API Documentation

Repo ini menyertakan paket Swagger (`darkaonline/l5-swagger` dan `zircote/swagger-php`). Untuk generate docs, lihat konfigurasi paket dan gunakan `php artisan l5-swagger:generate` jika tersedia.

## Tips Pengembangan

- Gunakan feature branches dan PR untuk perubahan besar.
- Gunakan seeder dan factories untuk membuat data uji yang konsisten.
- Simpan secrets di `.env` dan jangan commit file `.env` ke git.
- Jalankan `composer dump-autoload` bila menambahkan helper atau autoload baru.

## Troubleshooting umum

- Jika migrasi gagal pada fresh setup pastikan `database/database.sqlite` ada dan writable.
- Jika assets Vite tidak muncul, jalankan `npm run dev` dan periksa console browser untuk error.

## Kontribusi

Jika ingin berkontribusi: fork repo, buat branch baru, jalankan tests dan pastikan Pint lulus formatting. Kirim PR dengan deskripsi perubahan dan testing steps.

## Lisensi

MIT

## Kontak

Jika butuh bantuan spesifik untuk starter kit ini, sertakan langkah yang sudah dicoba dan error message yang muncul.
