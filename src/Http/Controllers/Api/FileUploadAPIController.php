<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers\Api;

use DanJamesMills\LaravelDropzone\Classes\FileUploader;
use DanJamesMills\LaravelDropzone\Classes\UploadSettings;
use Illuminate\Http\Request;

class FileUploadApiController
{
    /**
     * Store a newly created resource in storage.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        try {
            $uploadSettings = new UploadSettings($request->upload_type);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        $request->validate($uploadSettings->getFileValidationRules());

        $file = FileUploader::upload($request->file, $uploadSettings, $request->file_folder_id, ! $request->filled('model_id'));

        if ($uploadSettings->hasModel() && $request->model_id) {

            $record = ($uploadSettings->getModel())::findOrFail($request->model_id);

            return $record->files()->save($file);
        }

        return $file;
    }
}
