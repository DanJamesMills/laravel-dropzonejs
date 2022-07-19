<?php

namespace DanJamesMills\LaravelDropzone\Traits;

use DanJamesMills\LaravelDropzone\Models\File;
use DanJamesMills\LaravelDropzone\Models\FileFolder;
use Auth;

trait HasFile
{
    public function files()
    {
        return $this->morphToMany(File::class, 'model', 'model_has_files');
    }

    public function fileFolders()
    {
        return $this->morphMany(FileFolder::class, 'model');
    }

    public function getFileFoldersICanAccess()
    {
        if (Auth::user()->hasPermissionTo('access_all_files')) {
            return $this->fileFolders()
                ->whereNull('parent_file_folder_id')
                ->get();
        }

        return $this->getAnyoneFolders()
            ->merge($this->getOnlyMeFolders())
            ->merge($this->getSpecificUsersFolders());
    }

    public function getAnyoneFolders()
    {
        return $this->fileFolders()
            ->where('access_type', 1)
            ->whereNull('parent_file_folder_id')
            ->get();
    }

    public function getOnlyMeFolders()
    {
        return $this->fileFolders()
            ->where('access_type', 2)
            ->whereNull('parent_file_folder_id')
            ->where('user_id', Auth::id())
            ->get();
    }

    public function getSpecificUsersFolders()
    {
        return $this->fileFolders()
            ->where('access_type', 2)
            ->whereNull('parent_file_folder_id')
            ->where('user_id', Auth::id())
            ->get();
    }
}
