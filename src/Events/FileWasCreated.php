<?php

namespace DanJamesMills\LaravelDropzone\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use DanJamesMills\LaravelDropzone\Models\File;

class FileWasCreated
{
    use Dispatchable, SerializesModels;

    public $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }
}
