<?php

Route::group(['prefix' => 'api/v1', 'middleware' => ['web', 'auth'], 'namespace' => 'DanJamesMills\LaravelDropzone\Http\Controllers\Api'], function () {

    /* File Folder API Controller */
    Route::get('file-folders/{object}/{id}/', 'FileFolderAPIController@index');
    Route::post('file-folders/{object}/{id}', 'FileFolderAPIController@store');
});
