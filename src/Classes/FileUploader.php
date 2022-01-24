<?php

namespace DanJamesMills\LaravelDropzone\Classes;

use DanJamesMills\LaravelDropzone\Models\File;
use Illuminate\Support\Facades\Storage;

class FileUploader
{
    private $uploadType;

    private $request;

    private $file;

    private $newFileName;

    public function __construct($request)
    {
        $this->request = $request;
        $this->file = $request->file;

        $this->uploadType = new UploadType($request->has('upload_type') ? $request->upload_type : null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return App\File
     */
    public function upload()
    {
        $this->request->validate($this->uploadType->getFileValidationRules());

        return $this->storeFile();
    }

    private function hasModel()
    {
        return $this->uploadType->getModel() ? app($this->uploadType->getModel()) : false;
    }

    private function associateFileWithModel($model, $file)
    {
        $record = ($model)::findOrFail($this->request->model_id);

        return $record->files()->save($file);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return App\File
     */
    private function storeFile()
    {
        $this->newFileName = $this->generateRandomFileName(
            $this->file->getClientOriginalExtension()
        );

        $this->request->file('file')->storeAs(
            $this->uploadType->getPath(),
            $this->newFileName,
            $this->uploadType->getDisk()
        );

        return $this->storeFileInfoInDb();
    }

    /**
     * Store a newly created file information in database.
     *
     * @return App\File
     */
    private function storeFileInfoInDb()
    {
        $file = File::make([
            'file_folder_id' => $this->request->file_folder_id,
            'token' => $this->generateToken(),
            'original_filename' => $this->request->file->getClientOriginalName(),
            'storage_filename' => $this->newFileName,
            'mime_type' => $this->request->file->getMimeType(),
            'file_extension' => $this->request->file->getClientOriginalExtension(),
            'size' => $this->request->file->getSize(),
            'disk' => $this->uploadType->getDisk(),
            'path' => $this->uploadType->getPath(),
        ]);

        if ($model = $this->hasModel()) {
            return $this->associateFileWithModel($model, $file);
        }

        return $file->save();
    }

    /**
     * Generate random file name.
     * @param  string  $fileExtension
     * @return string
     */
    private function generateRandomFileName($fileExtension): string
    {
        return \Str::uuid().'.'.$fileExtension;
    }

    /**
     * Generate random token.
     * @return string
     */
    private function generateToken(): string
    {
        return \Str::uuid();
    }
}
