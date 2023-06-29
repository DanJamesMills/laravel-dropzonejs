<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers\Api;

use DanJamesMills\LaravelDropzone\Classes\FileUploader;
use DanJamesMills\LaravelDropzone\Classes\UploadSettings;
use Illuminate\Http\Request;

class FileUploadAPIController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $uploadSettings = new UploadSettings($request->upload_type);

        $request->validate($uploadSettings->getFileValidationRules());

        $file = FileUploader::upload($request->file, $uploadSettings, $request->file_folder_id);

        if ($uploadSettings->hasModel() && $request->model_id) {

            $record = ($uploadSettings->getModel())::findOrFail($request->model_id);

            return $record->files()->save($file);
        }

        return $file;
    }
}
