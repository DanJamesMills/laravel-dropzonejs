<?php

namespace DanJamesMills\LaravelDropzone\Classes;

use DanJamesMills\LaravelDropzone\Interfaces\UploadSettingsInterface;
use DanJamesMills\LaravelDropzone\Models\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class FileUploader
{
    /**
     * Upload a file into storage and save
     * the file information in the database.
     */
    public static function upload(UploadedFile $file, UploadSettingsInterface $uploadSettings, int $folderId = null, bool $isPreUpload = false): File
    {
        $newFileName = static::generateRandomFileName($file);

        $file->storeAs(
            $uploadSettings->getPath(),
            $newFileName,
            $uploadSettings->getDisk()
        );

        $fileModelClass = Config::get('laravel-dropzone.file_model');

        return $fileModelClass::create([
            'file_folder_id' => $folderId,
            'original_filename' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'storage_filename' => $newFileName,
            'mime_type' => $file->getMimeType(),
            'file_extension' => strtolower($file->getClientOriginalExtension()),
            'size' => $file->getSize(),
            'disk' => $uploadSettings->getDisk(),
            'path' => $uploadSettings->getPath(),
            'is_pre_upload' => $isPreUpload,
        ]);
    }

    /**
     * Generate a random file name.
     */
    private static function generateRandomFileName(UploadedFile $file): string
    {
        return Str::uuid().'.'.strtolower($file->getClientOriginalExtension());
    }
}
