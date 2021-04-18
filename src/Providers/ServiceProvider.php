<?php

namespace tizis\LevelSystem\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/user-levels.php' => config_path('user-levels.php'),
        ], 'config');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('/migrations'),
        ], 'migrations');


        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/user-levels.php',
            'levels'
        );
    }
}