# URL Shortener Service

## Requirements
- PHP 8.2+
- Laravel 12
- SQLite or MySQL
- Composer
- Node.js/npm (optional for auth scaffolding)

## Local Setup
1. Clone repository: `git clone YOUR_REPO_URL`
2. Copy env: `cp .env.example .env`
3. Generate key: `php artisan key:generate`
4. Setup SQLite: `touch database/database.sqlite`
5. Install dependencies: `composer install`
6. Run migrations & seed: `php artisan migrate --seed`
7. Start server: `php artisan serve`

SuperAdmin credentials:
- Email: superadmin@example.com
- Password: password

## Database
Uses SQLite by default (database/database.sqlite). Change DB_CONNECTION=mysql in .env for MySQL.
