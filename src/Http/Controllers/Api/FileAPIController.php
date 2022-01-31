<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers\Api;

use DanJamesMills\LaravelDropzone\Filters\FileFilters;
use App\Http\Controllers\AppBaseController;
use DanJamesMills\LaravelDropzone\Http\Requests\Api\UpdateFileAPIRequest;
use DanJamesMills\LaravelDropzone\Models\File;
use DanJamesMills\LaravelDropzone\Models\FileFolder;
use Illuminate\Http\Request;
use Auth;
use Response;

/**
 * Class FileController
 */
class FileAPIController extends AppBaseController
{
    /**
     * Display a listing of the File.
     * GET|HEAD /files
     *
     * @param FileFilters $request
     * @param string $model
     * @param integer $id
     *
     * @return Response
     */
    public function index(FileFilters $filters, string $object, int $id)
    {
        $record = ($this->getModelClass($object))::findOrFail($id);

        $currentPath = '/';
        $currentFolder = '';

        if ($filters->getRequest()->filled('fileFolderId')) {
            $currentFolder = FileFolder::findOrFail($filters->getRequest()->fileFolderId);

            $currentPath = $currentFolder->getRootPath();

            $files = $record->files()->whereFileFolderId($filters->getRequest()->fileFolderId)->get();

            $folders = $record->fileFolders()->whereParentFileFolderId($filters->getRequest()->fileFolderId)->get();
        } else {
            $files = $record->files()->whereNull('file_folder_id')->get();

            $folders = $record->getFileFoldersICanAccess();
        }

        $files = $files->toBase()->merge($folders);

        $meta = [
            'data' => $files->toArray(),
            'path' => $currentPath,
            'current_folder' => $currentFolder
        ];

        return $this->sendResponse($meta, 'Files retrieved successfully');
    }

    /**
     * Display the specified File.
     * GET|HEAD /files/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id)
    {
        $file = File::find($id);

        if (empty($file)) {
            return $this->sendError('File not found');
        }

        return $this->sendResponse($file->toArray(), 'File retrieved successfully');
    }

    /**
     * Update the specified File in storage.
     * PUT/PATCH /files/{id}
     *
     * @param int $id
     * @param UpdateFileAPIRequest $request
     *
     * @return Response
     */
    public function update(int $id, UpdateFileAPIRequest $request)
    {
        $file = File::find($id);

        if (empty($file)) {
            return $this->sendError('File not found');
        }

        $file->update($request->validated());

        return $this->sendResponse($file->toArray(), 'File updated successfully');
    }

    /**
     * Remove the specified File from storage.
     * DELETE /files/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy(int $id)
    {
        $file = File::find($id);

        if (empty($file)) {
            return $this->sendError('File not found');
        }

        $file->delete();

        return $this->sendSuccess('File deleted successfully');
    }

    // TODO Create Config File
    protected function getModelClass($className)
    {
        $modelClasses = [
            'contact' => \App\Models\Contact::class,
            'company' => \App\Models\Company::class,
            'task' => 'DanJamesMills\Tasks\Models\Task',
            'staff' => 'Utilda\Staff\Models\Staff',
        ];

        return $modelClasses[$className];
    }
}
