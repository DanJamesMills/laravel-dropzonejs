<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers\Api;

use DanJamesMills\LaravelDropzone\Http\Requests\Api\FileMoveAPIRequest;
use DanJamesMills\LaravelDropzone\Models\FileFolder;
use App\Http\Controllers\AppBaseController;
use DanJamesMills\LaravelDropzone\Models\File;
use Response;

/**
 * Class FileMoveAPIController
 * @package App\Http\Controllers\Api
 */

class FileMoveAPIController extends AppBaseController
{
    /**
     * Update the specified file folder in storage.
     * PUT/PATCH /file-move
     *
     * @param FileMoveAPIRequest $request
     * @param int $id
     *
     * @return Response
     */
    public function update(FileMoveAPIRequest $request)
    {
        $fileFolder = FileFolder::find($request->file_folder_id);

        if (empty($fileFolder)) {
            return $this->sendError('File folder not found');
        }

        if (!$fileFolder->hasAccessToFolder()) {
            return $this->sendError('You do not have permission to access this folder.');
        }

        foreach($request->file_ids as $fileId) {
            $file = File::find($fileId);

            if (empty($file)) {
                return $this->sendError('File not found');
            }

            $file->file_folder_id = $request->file_folder_id;
            $file->save();
        }

        return $this->sendResponse($fileFolder->toArray(), 'File moved successfully');
    }

    // TODO Create Config File
    protected function getModelClass($className)
    {
        $modelClasses = [
            'contact' => \App\Models\Contact::class,
            'company' => \App\Models\Company::class,
            'task' => 'DanJamesMills\Tasks\Models\Task',
            'staff' => 'Utilda\Staff\Models\Staff',
            'company-profile' => 'DanJamesMills\SettingsUi\Models\CompanyProfile'
        ];

        return $modelClasses[$className];
    }
}
