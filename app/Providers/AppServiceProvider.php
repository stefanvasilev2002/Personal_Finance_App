<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        View::addLocation('/app/resources/views');
        View::addLocation('/tmp/build_' . getenv('HEROKU_SLUG_COMMIT') . '/resources/views');

        Blade::component('layouts.app', 'app-layout');

    }
}
