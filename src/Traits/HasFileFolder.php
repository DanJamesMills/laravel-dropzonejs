<?php

namespace DanJamesMills\LaravelDropzone\Traits;

use DanJamesMills\LaravelDropzone\Models\FileFolder;
use DanJamesMills\LaravelDropzone\Enums\FolderAccessType;
use Auth;

trait HasFileFolder
{
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

        return $this->fileFolders()
            ->whereNull('parent_file_folder_id')
            ->where(function ($query) {
                $query->whereIn('access_type', FolderAccessType::getAllValues())
                      ->where(function ($query) {
                          $query->where('access_type', FolderAccessType::ACCESS_TYPE_ONLY_YOU)
                                ->where('user_id', Auth::id());
                      })
                      ->orWhere(function ($query) {
                          $query->where('access_type', FolderAccessType::ACCESS_TYPE_SPECIFIC_USERS)
                                ->whereHas('users', function ($query) {
                                    $query->where('users.id', Auth::id());
                                });
                      });
            })
            ->get();
    }
}