<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers\Api;

use DanJamesMills\LaravelResponse\Http\Controllers\BaseController;
use DanJamesMills\LaravelDropzone\Classes\UploadSettings;
use Illuminate\Http\JsonResponse;

class UploadSettingAPIController extends BaseController
{
    /**
     * Load configuration settings for specified upload type.
     *
     * @param string|null $uploadType
     *
     * @return JsonResponse
     */
    public function __invoke(?string $uploadType): JsonResponse
    {
        $uploadType = new UploadSettings($uploadType);

        $settings = [
            'allowed_file_types' => $this->getAllowedFileTypesString($uploadType),
            'max_file_size' => $uploadType->getMaxFileSizeLimit(),
        ];

        return $this->sendResponse($settings, 'Upload settings retrieved successfully.');
    }

    /**
     * Get a comma-separated string of allowed file types with "." in front of each type.
     *
     * @param UploadSettings $uploadType
     * 
     * @return string
     */
    private function getAllowedFileTypesString(UploadSettings $uploadType): string
    {
        return implode(',', array_map(function ($type) {
            return '.' . trim($type, '.');
        }, $uploadType->getAllowedFileTypes()));
    }
}
