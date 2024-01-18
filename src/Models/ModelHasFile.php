<?php

namespace DanJamesMills\LaravelDropzone\Models;

use DanJamesMills\LaravelDropzone\Events\FileAssociated;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class ModelHasFile extends MorphPivot
{
    protected $table = 'model_has_files';

    public static function boot()
    {
        parent::boot();

        $events = [
            'saved',
        ];

        foreach ($events as $event) {
            static::$event(function ($model) {
                FileAssociated::dispatch($model);
            });
        }
    }

    /**
     * Get the associated note model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        return $this->belongsTo(config('laravel-dropzone.file_model'));
    }
}
