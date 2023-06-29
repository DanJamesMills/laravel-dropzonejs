<?php

namespace DanJamesMills\LaravelDropzone;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;


class LaravelDropzoneServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->definePermissions();

        if ($this->app->runningInConsole()) {
            $this->registerPublishables();
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-dropzone.php', 'laravel-dropzone');
    }

    /**
     * Define permission defined in the config.
     */
    protected function definePermissions()
    {
        foreach(Config::get('laravel-dropzone.permissions', []) as $permission => $policy) {
            Gate::define($permission, $policy);
        }
    }

    protected function registerPublishables(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-dropzone.php' => config_path('laravel-dropzone.php'),
        ], 'laravel-dropzone-config');

        $this->publishes([
            __DIR__.'/../resources/js/components' => base_path('resources/js/components/laravel-dropzone'),
        ], 'laravel-dropzone-components');
    }
}
