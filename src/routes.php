<?php

Route::namespace('DanJamesMills\LaravelDropzone\Http\Controllers')->group(function () {
    Route::post('uploader', 'FileUploadController@store')
        ->name('uploader.store');

    Route::post('uploader/file/delete', 'FileUploadController@destroy')
        ->name('uploader.destroy');

    Route::get('uploader/file/{token}/download', 'FileDownloadController@download')
        ->name('uploader.download');

    Route::get('uploader/{uploadType}/settings', 'UploadTypeSettingController@show')
        ->name('uploader.settings');
});
