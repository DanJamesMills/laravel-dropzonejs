<?php

namespace DanJamesMills\LaravelDropzone\Events;

use Illuminate\Queue\SerializesModels;
use DanJamesMills\LaravelDropzone\Models\File;

class FileCreated
{
    use SerializesModels;

    public $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }
}
