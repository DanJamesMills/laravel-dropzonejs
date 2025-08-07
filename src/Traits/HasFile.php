<?php

namespace DanJamesMills\LaravelDropzone\Traits;

use DanJamesMills\LaravelDropzone\Classes\Storage;
use DanJamesMills\LaravelDropzone\Models\File;

trait HasFile
{

    /**
     * Define a one-to-one polymorphic relationship with the File model.
     */
    public function file()
    {
        return $this->morphOne(config('laravel-dropzone.file_model'), 'model');
    }

    public function storage(): Storage
    {
        return new Storage($this);
    }

    /**
     * Associate files with the model if they have not been associated already.
     */
    public function associateFiles(array $tokens): void
    {
        $files = File::whereIn('token', $tokens)
            ->isPreUpload()
            ->get();

        foreach ($files as $file) {
            $file->model_id = $this->id;
            $file->model_type = $this->getMorphClass();
            $file->is_pre_upload = false;
            $file->save();
        }
    }
}
