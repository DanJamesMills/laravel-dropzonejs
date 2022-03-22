<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DanJamesMills\LaravelDropzone\Classes\UploadSettings;
use Response;

class UploadSettingController extends Controller
{
    /**
     * Load configuration settings for specified upload type.
     *
     * @param string $uploadType
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke($uploadType)
    {
        $uploadType = new UploadSettings($uploadType ? $uploadType : null);

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
