<?php

namespace DanJamesMills\LaravelDropzone\Policies;

use DanJamesMills\LaravelDropzone\Models\File;
use Illuminate\Database\Eloquent\Model;

class FilePolicy
{
    /**
     * Determine if the given user can view any files for the fileable model.
     *
     * @param  mixed  $user
     * @param  Model  $fileableModel
     * @return bool
     */
    public function viewAny($user, Model $fileableModel): bool
    {
        return false;
    }

    /**
     * Determine if the given user can view the specified file.
     *
     * @param  mixed  $user
     * @param  File  $file
     * @return bool
     */
    public function view($user, File $file): bool
    {
        return false;
    }

    /**
     * Determine if the given user can create a new file for the fileable model.
     *
     * @param  mixed  $user
     * @param  Model  $fileableModel
     * @return bool
     */
    public function create($user, Model $fileableModel): bool
    {
        return false;
    }

    /**
     * Determine if the given user can download the file.
     *
     * @param  mixed  $user
     * @param  File  $file
     * @return bool
     */
    public function download($user, File $file): bool
    {
        return false;
    }

    /**
     * Determine if the given user can update the specified file.
     *
     * @param  mixed  $user
     * @param  File  $file
     * @return bool
     */
    public function update($user, File $file): bool
    {
        return false;
    }

    /**
     * Determine if the given user can delete the specified file.
     *
     * @param  mixed  $user
     * @param  File  $file
     * @return bool
     */
    public function delete($user, File $file): bool
    {
        return false;
    }
}
