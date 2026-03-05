<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Contact;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        
        // Передаем контакты во все шаблоны для SEO
        View::composer('*', function ($view) {
            $view->with('contacts', Contact::active()->orderBy('sort_order')->get());
            $view->with('settings', Setting::all()->keyBy('key_name'));
        });
        
        // Schema.org разметка для всех страниц
        View::composer('client.layouts.app', function ($view) {
            $view->with('schema_organization', [
                '@context' => 'https://schema.org',
                '@type' => 'BeautySalon',
                'name' => 'VCM Laser',
                'description' => 'Салон лазерной эпиляции в Волжеске',
                'url' => config('app.url'),
                'logo' => asset('images/logo.png'),
                'image' => asset('images/og-image.jpg'),
                'telephone' => '+79991234567',
                'email' => 'info@vcm-laser.ru',
                'priceRange' => '1500-10000₽',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => 'Москва',
                    'streetAddress' => 'ул. Лазерная, д. 10'
                ],
                'openingHours' => 'Mo-Fr 10:00-21:00, Sa-Su 11:00-19:00'
            ]);
        });
    }
}