<?php

namespace DanJamesMills\LaravelDropzone\Models\Traits;

use DanJamesMills\LaravelDropzone\Models\File;
use DanJamesMills\LaravelDropzone\Models\FileFolder;

trait HasFile
{
    public function files()
    {
        return $this->morphMany(File::class, 'model');
    }

    public function fileFolders()
    {
        return $this->morphMany(FileFolder::class, 'model');
    }
}
