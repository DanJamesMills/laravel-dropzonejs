<?php

$middleware = config('laravel-dropzone.web_middleware', []);
$prefix = config('laravel-dropzone.web_prefix', '');

Route::group(['prefix' => $prefix, 'middleware' => $middleware, 'namespace' => 'DanJamesMills\LaravelDropzone\Http\Controllers'], function () {

    Route::get('file/{token}/download', 'FileDownloadController')
        ->name('uploader.download');

});
