<?php

Route::namespace('DanJamesMills\LaravelDropzone\Http\Controllers')->middleware(['web', 'auth'])->group(function () {

    Route::get('file/{token}/download', 'FileDownloadController')
        ->name('uploader.download');

});
