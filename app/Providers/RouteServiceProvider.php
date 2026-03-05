<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Путь к "домашней" странице пользователя.
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // API маршруты
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Web маршруты (клиентская часть)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            // Админские маршруты
            Route::middleware('web')
                ->group(base_path('routes/admin.php'));

            // Маршруты аутентификации
            Route::middleware('web')
                ->group(base_path('routes/auth.php'));
        });
    }
}