<?php

$middleware = config('laravel-dropzone.api_middleware', []);
$prefix = config('laravel-dropzone.api_prefix', 'api/v1');

Route::group(['prefix' => $prefix, 'middleware' => $middleware, 'namespace' => 'DanJamesMills\LaravelDropzone\Http\Controllers\Api'], function () {

    Route::get('uploader/{uploadType}/settings', 'UploadSettingAPIController');

    Route::post('uploader', 'FileUploadAPIController');

    // Route::post('uploader/file/delete', 'FileUploadController@destroy');

    /* File Controller */
    Route::get('files/{object}/{id}/', 'FileApiController@index');
    Route::get('files/{token}', 'FileApiController@show');
    Route::put('files/{token}', 'FileApiController@update');
    Route::delete('files/{token}', 'FileApiController@destroy');

    /* File Folder Api Controller */
    Route::get('file-folders/{object}/{id}/', 'FileFolderApiController@index');
    Route::get('file-folders/{id}', 'FileFolderApiController@show');
    Route::post('file-folders/{object}/{id}', 'FileFolderApiController@store');
    Route::put('file-folders/{id}', 'FileFolderApiController@update');
    Route::delete('file-folders/{id}', 'FileFolderApiController@destroy');
});
