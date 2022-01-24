<?php

namespace DanJamesMills\LaravelDropzone;

use DanJamesMills\LaravelDropzone\View\Components\LaravelDropzone;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-dropzone');

        Blade::component('laravel-dropzone', LaravelDropzone::class);

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
