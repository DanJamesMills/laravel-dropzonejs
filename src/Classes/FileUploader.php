<?php

namespace DanJamesMills\LaravelDropzone\Classes;

use DanJamesMills\LaravelDropzone\Interfaces\UploadSettingsInterface;
use DanJamesMills\LaravelDropzone\Models\File;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileUploader
{
    /**
     * Upload a file into storage and save
     * the file information in the database.
     *
     * @param UploadedFile $file
     * @param UploadSettingsInterface $uploadSettings
     * @param int|null $folderId
     *
     * @return File
     */
    public static function upload(UploadedFile $file, UploadSettingsInterface $uploadSettings, int $folderId = null): File
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
        ]);
    }

    /**
     * Generate a random file name.
     *
     * @param UploadedFile $file
     *
     * @return string
     */
    private static function generateRandomFileName(UploadedFile $file): string
    {
        return Str::uuid() . '.' . strtolower($file->getClientOriginalExtension());
    }
}
