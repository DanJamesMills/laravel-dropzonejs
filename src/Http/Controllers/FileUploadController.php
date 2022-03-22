<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers;

use App\Http\Controllers\Controller;
use DanJamesMills\LaravelDropzone\Classes\FileUploader;
use DanJamesMills\LaravelDropzone\Models\File;
use DanJamesMills\LaravelDropzone\Classes\UploadSettings;
use Illuminate\Http\Request;
use DanJamesMills\LaravelDropzone\Events\FileWasCreated;

class FileUploadController extends Controller
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

        $fileUploader = new FileUploader($request->file, $uploadSettings, $request->file_folder_id);

        $file = $fileUploader->upload();

        if ($uploadSettings->hasModel()) {
            $record = ($uploadSettings->getModel())::findOrFail($request->model_id);

            return $record->files()->save($file);
        }

        event(new FileWasCreated($file));

        return $file;
    }
}
