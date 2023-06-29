<?php

$middleware = config('laravel-dropzone.api_middleware', []);
$prefix = config('laravel-dropzone.api_prefix', 'api/v1');

Route::group(['prefix' => $prefix, 'middleware' => $middleware, 'namespace' => 'DanJamesMills\LaravelDropzone\Http\Controllers\Api'], function () {

    Route::get('uploader/{uploadType}/settings', 'UploadSettingAPIController');

    Route::post('uploader', 'FileUploadAPIController');

    // Route::post('uploader/file/delete', 'FileUploadController@destroy');

    /* File Controller */
    Route::get('files/{object}/{id}/', 'FileAPIController@index');
    Route::get('files/{file}/', 'FileAPIController@show');
    Route::put('files/{file}', 'FileAPIController@update');
    Route::delete('files/{file}', 'FileAPIController@destroy');

    /* File Folder API Controller */
    Route::get('file-folders/{object}/{id}/', 'FileFolderAPIController@index');
    Route::get('file-folders/{id}', 'FileFolderAPIController@show');
    Route::post('file-folders/{object}/{id}', 'FileFolderAPIController@store');
    Route::put('file-folders/{id}', 'FileFolderAPIController@update');
    Route::delete('file-folders/{id}', 'FileFolderAPIController@destroy');
});
