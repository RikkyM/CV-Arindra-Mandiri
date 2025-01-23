<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        Blade::component('app', 'app');
        Blade::component('components.layouts.auth', 'components.layouts.auth');
        Blade::component('components.layouts.admin', 'components.layouts.admin');
        Blade::component('components.layouts.users', 'components.layouts.users');
    }
}
