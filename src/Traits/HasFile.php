<?php

namespace DanJamesMills\LaravelDropzone\Traits;

use DanJamesMills\LaravelDropzone\Models\File;
use DanJamesMills\LaravelDropzone\Models\FileFolder;
use Auth;

trait HasFile
{
    public function files()
    {
        return $this->morphMany(File::class, 'model');
    }

    public function fileFolders()
    {
        return $this->morphMany(FileFolder::class, 'model');
    }

    public function getFileFoldersICanAccess()
    {
        $anyoneFolders = $this->fileFolders()->where('access_type', 1)->get();

        $onlyMe = $this->fileFolders()->where('access_type', 2)->where('user_id', Auth::id())->get();

        $specificUsersFolders = $this->fileFolders()->whereHas('users', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return $anyoneFolders->merge($onlyMe)->merge($specificUsersFolders);
    }
}
