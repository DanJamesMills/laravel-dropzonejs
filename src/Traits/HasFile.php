<?php

namespace DanJamesMills\LaravelDropzone\Traits;

use DanJamesMills\LaravelDropzone\Classes\Storage;
use DanJamesMills\LaravelDropzone\Models\File;

trait HasFile
{
    use HasFileFolder;

    /**
     * Define a many-to-many relationship with the File model.
     */
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files');
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
            $this->files()->save($file);

            $file->is_pre_upload = false;

            $file->save();
        }
    }
}
