<?php

$middleware = config('laravel-dropzone.api_middleware', []);
$prefix = config('laravel-dropzone.api_prefix', 'api/v1');

Route::group(['prefix' => $prefix, 'middleware' => $middleware, 'namespace' => 'DanJamesMills\LaravelDropzone\Http\Controllers\Api'], function () {

    Route::get('uploader/{uploadType}/settings', 'UploadSettingApiController');

    Route::post('uploader', 'FileUploadApiController');

    /* File Controller */
    Route::get('files/{model}/{modelId}/', 'FileApiController@index');
    Route::get('files/{token}', 'FileApiController@show');
    Route::put('files/{token}', 'FileApiController@update');
    Route::delete('files/{token}', 'FileApiController@destroy');

});
