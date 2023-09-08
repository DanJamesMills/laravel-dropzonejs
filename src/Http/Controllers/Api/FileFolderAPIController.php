<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers\Api;

use Auth;
use DanJamesMills\LaravelDropzone\Http\Requests\Api\CreateFileFolderApiRequest;
use DanJamesMills\LaravelDropzone\Http\Requests\Api\UpdateFileFolderApiRequest;
use DanJamesMills\LaravelDropzone\Models\FileFolder;
use DanJamesMills\LaravelResponse\Http\Controllers\BaseController;
use Response;

class FileFolderApiController extends BaseController
{
    /**
     * Store a newly created file folder in storage.
     * POST /file-folders/{object}/{id}/
     *
     *
     * @return Response
     */
    public function store(CreateFileFolderApiRequest $request, string $model, int $id)
    {
        $record = ($this->getModelClass($model))::findOrFail($id);

        $fileFolder = FileFolder::create($request->validated());

        if ($request->filled('user_ids')) {
            $fileFolder->users()->attach(array_merge($request->user_ids, [Auth::id()]));
        }

        $record->fileFolders()->save($fileFolder);

        return $this->sendResponse($fileFolder->load('user')->toArray(), 'File folder saved successfully');
    }

    /**
     * Display the specified file folder.
     * GET|HEAD /file-folders/{id}
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $fileFolder = FileFolder::with('users')->find($id);

        if (empty($fileFolder)) {
            return $this->sendError('File folder not found');
        }

        if (! $fileFolder->hasAccessToFolder()) {
            return $this->sendError('You do not have permission to access this folder.');
        }

        return $this->sendResponse($fileFolder->toArray(), 'File folder retrieved successfully');
    }

    /**
     * Update the specified file folder in storage.
     * PUT/PATCH /file-folder/{id}
     *
     *
     * @return Response
     */
    public function update(UpdateFileFolderApiRequest $request, int $id)
    {
        $fileFolder = FileFolder::find($id);

        if (empty($fileFolder)) {
            return $this->sendError('File folder not found');
        }

        if (! $fileFolder->hasAccessToFolder()) {
            return $this->sendError('You do not have permission to access this folder.');
        }

        $fileFolder->update($request->validated());

        if ($request->filled('user_ids')) {
            $fileFolder->users()->sync($request->user_ids);
        }

        return $this->sendResponse($fileFolder->toArray(), 'File folder updated successfully');
    }

    /**
     * Remove the specified file folder from storage.
     * DELETE /file-folder/{id}
     *
     * @param  int  $id
     * @return Response
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $fileFolder = FileFolder::find($id);

        if (empty($fileFolder)) {
            return $this->sendError('File folder not found');
        }

        if (! $fileFolder->hasAccessToFolder()) {
            return $this->sendError('You do not have permission to access this folder.');
        }

        if ($fileFolder->isSystemDefault()) {
            return $this->sendError('This file folder is provided by WorkCRM and cannot be deleted.', $code = 400);
        }

        $fileFolder->delete();

        return $this->sendSuccess('File folder deleted successfully');
    }

    // TODO Create Config File
    protected function getModelClass($className)
    {
        $modelClasses = [
            'contact' => \App\Models\Contact::class,
            'company' => \App\Models\Company::class,
            'task' => 'DanJamesMills\Tasks\Models\Task',
            'staff' => 'Utilda\Staff\Models\Staff',
            'company-profile' => 'DanJamesMills\SettingsUi\Models\CompanyProfile',
        ];

        return $modelClasses[$className];
    }
}
