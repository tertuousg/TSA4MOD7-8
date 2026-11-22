# Tasks for Today Management System — IT0049 TSA4

Laravel 13 application implementing full task CRUD, Breeze-compatible authentication, soft archiving, validation, and a completion email notification.

## Requirements

- PHP 8.3+
- Composer
- Node.js 20+
- SQLite, MySQL, or another Laravel-supported database

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Open `http://localhost:8000`.

Seeded demo account:

- Email: `admin@example.com`
- Password: `password`

Change this password before deploying.

## Email notification

The default `.env` uses Laravel's safe `log` mail driver:

```env
MAIL_MAILER=log
TASK_NOTIFICATION_EMAIL=student@example.com
```

When a pending or in-progress task changes to `done`, `TaskController@update` sends `App\Mail\TaskCompleted`. The message is written to `storage/logs/laravel.log`. Updating a task that was already `done` does not send another email because the controller checks the previous status.

For SMTP testing, replace the mail settings with the credentials from Mailpit, Mailtrap, or another safe test SMTP service.

## Breeze/authentication

The project includes the `laravel/breeze` dependency and a Blade-style authentication flow. If you want to regenerate the official Breeze scaffolding in a fresh Laravel installation, use:

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
php artisan migrate
```

Keep the task routes, controller, mail class, and views from this project when merging the generated Breeze files.

## Required flow for demonstration

1. Visit `/tasks` while logged out; the list and details are public.
2. Log in using the seeded account or register a new account.
3. Create a task with status `pending`.
4. Edit it and change status to `done`.
5. Check `storage/logs/laravel.log` for the generated email.
6. Edit the same completed task again; no second completion email is generated.
7. Archive a task and confirm it disappears from the active list while its row remains in the database with `is_archived = 1`.

## Main files

| Purpose | File |
|---|---|
| Routes | `routes/web.php` |
| CRUD controller | `app/Http/Controllers/TaskController.php` |
| Authentication | `app/Http/Controllers/AuthController.php` |
| Task model | `app/Models/Task.php` |
| Completion mail | `app/Mail/TaskCompleted.php` |
| Task migration | `database/migrations/2026_01_01_000001_create_tasks_table.php` |
| Seed data | `database/seeders/DatabaseSeeder.php` |
| Task pages | `resources/views/tasks/` |
| Email view | `resources/views/emails/task-completed.blade.php` |
