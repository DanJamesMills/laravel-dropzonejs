<?php

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth:api', 'namespace' => 'DanJamesMills\LaravelDropzone\Http\Controllers\Api'], function () {

    /* File Folder API Controller */
    Route::get('file-folders/{object}/{id}/', 'FileFolderAPIController@index');
    Route::post('file-folders/{object}/{id}', 'FileFolderAPIController@store');
    // Route::get('file-folders/{note}/', 'NoteAPIController@show');
    // Route::put('file-folders/{note}', 'NoteAPIController@update');
    // Route::delete('file-folders/{note}', 'NoteAPIController@destroy');
});
