<?php

namespace DanJamesMills\LaravelDropzone\Events;

use Illuminate\Queue\SerializesModels;
use DanJamesMills\LaravelDropzone\Models\FileFolder;

class FileFolderDeleted
{
    use SerializesModels;

    public $fileFolder;

    public function __construct(FileFolder $fileFolder)
    {
        $this->fileFolder = $fileFolder;
    }
}
