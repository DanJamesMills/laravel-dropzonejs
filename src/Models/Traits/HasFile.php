<?php

namespace DanJamesMills\LaravelDropzone\Models\Traits;

use DanJamesMills\LaravelDropzone\Models\File;

trait HasFile
{
    public function files()
    {
        return $this->morphMany(File::class, 'model');
    }
}
