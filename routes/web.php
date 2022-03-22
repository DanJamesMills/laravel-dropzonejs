<?php

Route::namespace('DanJamesMills\LaravelDropzone\Http\Controllers')->middleware(['web', 'auth'])->group(function () {
    Route::post('uploader', 'FileUploadController')
        ->name('uploader.store');

    Route::post('uploader/file/delete', 'FileUploadController@destroy')
        ->name('uploader.destroy');

    Route::get('file/{token}/download', 'FileDownloadController@download')
        ->name('uploader.download');

    Route::get('uploader/{uploadType}/settings', 'UploadSettingController')
        ->name('uploader.settings');
});
