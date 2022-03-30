<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers;

use App\Http\Controllers\Controller;
use DanJamesMills\LaravelDropzone\Models\File;

class FileDownloadController extends Controller
{
    /**
     * Find and emit download of file.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function download($token)
    {
        $file = File::whereToken($token)->firstOrFail();

        return $file->previewFile();

        return $file->downloadFile();
    }
}
