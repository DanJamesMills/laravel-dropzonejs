<?php

namespace DanJamesMills\LaravelDropzone\Classes;

use Illuminate\Database\Eloquent\Model;

class Storage
{

    protected Model $model;

    protected int $fileFolderId;

    protected $currentFolder;

    protected $folders = [];

    protected $files = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all files and folders based on the provided folder ID.
     *
     * @param int|null $fileFolderId
     * @return array
     */
    public function allFiles(?int $fileFolderId = null)
    {
        if(!empty($fileFolderId)) {
            $this->fileFolderId = $fileFolderId;
            $this->currentFolder = $this->getCurrentFolder();

            $this->folders = $this->getSubfolders();
            $this->files = $this->getFilesWithinFolder();
        } else {
            $this->folders = $this->getRootFolders();
            $this->files = $this->getRootFiles();
        }

        return [
            'folders' => $this->folders,
            'files' => $this->files,
            'currentPath' => $this->getCurrentPath(),
        ];
    }

    protected function getCurrentPath()
    {
        return ($this->currentFolder) ? $this->currentFolder->getRootPath() : [];
    }

    protected function getCurrentFolder()
    {
        return $this->model->fileFolders()->find($this->fileFolderId);
    }

    protected function getRootFolders()
    {
        return $this->model->fileFolders()->rootFolders()->get();
    }

    protected function getRootFiles()
    {
        return $this->model->files()->noFolder()->get();
    }

    protected function getSubfolders()
    {
        return $this->currentFolder->subfolders;
    }

    protected function getFilesWithinFolder()
    {
        return $this->currentFolder->files;
    }
}

