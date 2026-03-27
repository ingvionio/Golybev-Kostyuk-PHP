<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Enums\Role;
use SupportModule\ReportManager;
use PDO;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Регистрируем наш класс ReportManager в DI-контейнере
        $this->app->singleton(ReportManager::class, function ($app) {
            // Достаем подключение к БД
            $connection = config('database.default');
            $database = config("database.connections.{$connection}.database");

            // Инициализируем чистый PDO для работы с нашим модулем
            $pdo = new PDO("sqlite:" . $database);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return new ReportManager($pdo);
        });
    }

    public function boot(): void
    {
        Gate::define('admin-access', function ($user) {
            return $user->role === Role::ADMIN;
        });
    }
}