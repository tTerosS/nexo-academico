<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Evita errores si la tabla aún no existe durante migraciones
        if (Schema::hasTable('settings')) {
            $institutionName = Setting::get('institution_name', 'GRUPO OSALVAC SRL');
            $primaryColor = Setting::get('primary_color', '#4f46e5');
            $welcomeMessage = Setting::get('welcome_message', 'Bienvenido a la plataforma educativa NEXO Campus.');

            View::share('institutionName', $institutionName);
            View::share('primaryColor', $primaryColor);
            View::share('welcomeMessage', $welcomeMessage);
        }
    }
}