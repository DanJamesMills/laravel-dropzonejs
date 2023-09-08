<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers\Api;

use DanJamesMills\LaravelDropzone\Classes\UploadSettings;
use DanJamesMills\LaravelDropzone\Filters\FileFilters;
use DanJamesMills\LaravelDropzone\Http\Requests\Api\UpdateFileAPIRequest;
use DanJamesMills\LaravelDropzone\Models\FileFolder;
use DanJamesMills\LaravelResponse\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Response;

class FileApiController extends BaseController
{
    /**
     * The file model class.
     *
     * @var string
     */
    protected $fileModelClass;

    public function __construct()
    {
        $this->fileModelClass = Config::get('laravel-dropzone.file_model');
    }

    /**
     * Display a listing of the File.
     * GET|HEAD /files
     *
     * @param  FileFilters  $request
     * @return Response
     */
    public function index(FileFilters $filters, string $uploadType, int $id)
    {
        $uploadSettings = new UploadSettings($uploadType);

        $record = ($uploadSettings->getModel())::findOrFail($id);

        // $record->listDirectory();

        $currentPath = '/';
        $currentFolder = '';

        if ($filters->getRequest()->filled('fileFolderId')) {
            $currentFolder = FileFolder::findOrFail($filters->getRequest()->fileFolderId);

            $currentPath = $currentFolder->getRootPath();

            $files = $currentFolder->files;

            $folders = $record->fileFolders()->whereParentFileFolderId($filters->getRequest()->fileFolderId)->get();
        } else {
            $files = $record->files()->whereNull('file_folder_id')->get();

            $folders = $record->getFileFoldersICanAccess();
        }

        $files = $files->toBase()->merge($folders);

        $meta = [
            'data' => $files->toArray(),
            'path' => $currentPath,
            'current_folder' => $currentFolder,
        ];

        return $this->sendResponse($meta, 'Files retrieved successfully');
    }

    /**
     * Display the specified File.
     * GET|HEAD /files/{token}
     *
     *
     * @return Response
     */
    public function show(string $token)
    {
        $file = $this->fileModelClass::whereToken($token)->first();

        if (empty($file)) {
            return $this->sendError('File not found');
        }

        Gate::authorize(
            'view-file',
            $file
        );

        return $this->sendResponse($file->toArray(), 'File retrieved successfully');
    }

    /**
     * Update the specified File in storage.
     * PUT/PATCH /files/{token}
     *
     *
     * @return Response
     */
    public function update(string $token, UpdateFileApiRequest $request)
    {
        $file = $this->fileModelClass::whereToken($token)->first();

        if (empty($file)) {
            return $this->sendError('File not found');
        }

        Gate::authorize(
            'update-file',
            $file
        );

        $file->update($request->validated());

        return $this->sendResponse($file->toArray(), 'File updated successfully');
    }

    /**
     * Remove the specified File from storage.
     * DELETE /files/{token}
     *
     *
     * @throws \Exception
     */
    public function destroy(string $token): JsonResponse
    {
        $file = $this->fileModelClass::whereToken($token)->first();

        if (empty($file)) {
            return $this->sendError('File not found');
        }

        Gate::authorize(
            'delete-file',
            $file
        );

        $file->delete();

        return $this->sendSuccess('File deleted successfully.');
    }
}
