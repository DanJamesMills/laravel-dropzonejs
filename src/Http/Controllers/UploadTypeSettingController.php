<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DanJamesMills\LaravelDropzone\Classes\UploadType;
use Response;

class UploadTypeSettingController extends Controller
{
    /**
     * Load configuration settings for specified upload type.
     *
     * @param string $uploadType
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($uploadType, Request $request)
    {
        $uploadType = new UploadType($uploadType ? $uploadType : null);

        $data = [
            'allowed_file_types' => $uploadType->getAllowedFileTypes(),
            'max_file_size_in_mb' => $uploadType->getMaxFileSizeLimit(true),
        ];

        return Response::json([
            'success' => true,
            'data' => $data
        ], 200);
    }
}
