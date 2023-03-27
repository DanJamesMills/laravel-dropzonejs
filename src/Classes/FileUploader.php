<?php

namespace DanJamesMills\LaravelDropzone\Classes;

use DanJamesMills\LaravelDropzone\Models\File;
use Illuminate\Support\Facades\Storage;
use DanJamesMills\LaravelDropzone\Classes\UploadSettings;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class FileUploader
{
    /**
     * @var UploadedFile;
     */
    private $file;

    /**
     * @var UploadSettings;
     */
    private $uploadSettings;

    /**
     * @var integer;
     */
    private $folderId;

    /**
     * @var string;
     */
    private $newFileName;

    /**
     * @var File;
     */
    private $fileModel;

    public function __construct(UploadedFile $file, UploadSettings $uploadSettings, int $folderId = null)
    {
        $this->file = $file;

        $this->uploadSettings = $uploadSettings;

        $this->folderId = $folderId;
    }

    /**
     * Upload the file into storage and save
     * the file information in the database.
     *
     * @return File
     */
    public function upload()
    {
        $this->generateRandomFileName();
        $this->uploadFileIntoStorage();
        $this->storeFileInfoInDb();

        return $this->fileModel;
    }

    /**
     * Store a newly created resource in storage.
     */
    private function uploadFileIntoStorage()
    {
        $this->file->storeAs(
            $this->uploadSettings->getPath(),
            $this->newFileName,
            $this->uploadSettings->getDisk()
        );
    }

    /**
     * Store a newly created file information in database.
     */
    private function storeFileInfoInDb()
    {
        $this->fileModel = File::create([
            'file_folder_id' => $this->folderId,
            'original_filename' => pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME),
            'storage_filename' => $this->newFileName,
            'mime_type' => $this->file->getMimeType(),
            'file_extension' => strtolower($this->file->getClientOriginalExtension()),
            'size' => $this->file->getSize(),
            'disk' => $this->uploadSettings->getDisk(),
            'path' => $this->uploadSettings->getPath(),
        ]);
    }

    /**
     * Generate a random file name.
     */
    private function generateRandomFileName()
    {
        $this->newFileName = Str::uuid() . '.' . strtolower($this->file->getClientOriginalExtension());
    }
}
