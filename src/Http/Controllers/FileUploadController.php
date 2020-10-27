<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers;

use App\Http\Controllers\Controller;
use DanJamesMills\LaravelDropzone\Classes\FileUploader;
use DanJamesMills\LaravelDropzone\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileUploader = new FileUploader($request);

        return $fileUploader->upload();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $file = File::whereToken($request->token)->firstOrFail();

        return $file->delete();
    }
}
