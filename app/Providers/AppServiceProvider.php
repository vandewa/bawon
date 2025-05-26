<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
            if (env('APP_ENV') != 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }

         Schema::defaultStringLength(191);
         Schema::defaultMorphKeyType('string');
    }
}
