<?php

namespace DanJamesMills\LaravelDropzone\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FileAssociated
{
    use SerializesModels;
    use Dispatchable;

    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
