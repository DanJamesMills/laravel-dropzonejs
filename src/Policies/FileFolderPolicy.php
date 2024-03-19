<?php

namespace DanJamesMills\LaravelDropzone\Policies;

use DanJamesMills\LaravelDropzone\Models\FileFolder;
use Illuminate\Database\Eloquent\Model;

class FileFolderPolicy
{
    /**
     * Determine if the given user can view any files within a specific fileable model context.
     *
     * @param  mixed  $user The user attempting to perform the action.
     * @param  Model  $fileFolderableModel The model instance that file folders are related to.
     * @return bool True if the user can view any files, false otherwise.
     */
    public function viewAny($user, Model $fileFolderableModel): bool
    {
        return false;
    }

    /**
     * Determine if the given user can view the specified file folder.
     *
     * @param  mixed  $user The user attempting to perform the action.
     * @param  FileFolder  $fileFolder The file folder instance being accessed.
     * @return bool True if the user can view the file folder, false otherwise.
     */
    public function view($user, FileFolder $fileFolder): bool
    {
        return false;
    }

    /**
     * Determine if the given user can create a new file folder for the fileFolderableModel model.
     *
     * @param  mixed  $user The user attempting to perform the action.
     * @param  Model  $fileFolderableModel The model instance that the new file folder will be related to.
     * @return bool True if the user can create a file folder, false otherwise.
     */
    public function create($user, Model $fileFolderableModel): bool
    {
        return false;
    }

    /**
     * Determine if the given user can update the specified file folder.
     *
     * @param  mixed  $user The user attempting to perform the action.
     * @param  FileFolder  $fileFolder The file folder instance to be updated.
     * @return bool True if the user can update the file folder, false otherwise.
     */
    public function update($user, FileFolder $fileFolder): bool
    {
        return false;
    }

    /**
     * Determine if the given user can delete the specified file folder.
     *
     * @param  mixed  $user The user attempting to perform the action.
     * @param  FileFolder  $fileFolder The file folder instance to be deleted.
     * @return bool True if the user can delete the file folder, false otherwise.
     */
    public function delete($user, FileFolder $fileFolder): bool
    {
        return false;
    }
}
