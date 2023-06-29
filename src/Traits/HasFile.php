<?php

namespace DanJamesMills\LaravelDropzone\Traits;

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

    /**
     * Associate files with the model if they have not been associated already.
     *
     * @param array $tokens
     * @return void
     */
    public function associateFiles(array $tokens): void
    {
        File::whereIn('token', $tokens)
            ->whereNull('model_type')
            ->update([
                'model_id' => $this->id, 
                'model_type' => get_class($this)
            ]);
    }
}
