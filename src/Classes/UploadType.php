<?php

namespace DanJamesMills\LaravelDropzone\Classes;

class UploadType
{
    /**
     * The upload type of which config we should use.
     *
     * @var string
     */
    private $uploadType;

    public function __construct($uploadType = null)
    {
        $this->setUploadType($uploadType);
    }

    /**
     * Set upload type.
     *
     * @param  string  $uploadType
     * @return string
     */
    private function setUploadType($uploadType): void
    {
        $this->uploadType = $uploadType;

        if ($uploadType != null) {
            $this->checkUploadTypeExistInConfig();
        }
    }

    /**
     * Check to see if config values exist for upload type.
     *
     * @return bool
     */
    private function checkUploadTypeExistInConfig()
    {
        if (! config()->has('laravel-dropzone.'.$this->uploadType)) {
            abort(500, 'Upload Type does not exist in config/laravel-dropzone.php config file (Error Code 673).');
        }
    }

    /**
     * Remove . prefix from allowed file types so Laravel validator can use.
     *
     * @param  string  $string
     * @return string
     */
    private function removeDotPrefix($string)
    {
        return str_replace('.', '', $string);
    }

    /**
     * Convert bytes to megabytes
     *
     * @param  int  $megabytes
     * @return int
     */
    private function formatMegabytesToBytes($megabytes)
    {
        return 1024 * 1024 * $megabytes;
    }

    /**
     * Return which disk to use for Filesystem Disks from config file for upload type.
     *
     * @return string
     */
    public function getDisk(): string
    {
        return config('laravel-dropzone.'.$this->uploadType.'.disk') ?
            config('laravel-dropzone.'.$this->uploadType.'.disk') :
            config('laravel-dropzone.default.disk');
    }

    /**
     * Return upload path from config file for upload type.
     *
     * @return string
     */
    public function getPath(): string
    {
        return config('laravel-dropzone.'.$this->uploadType.'.path') ?
            config('laravel-dropzone.'.$this->uploadType.'.path') :
            config('laravel-dropzone.default.path');
    }

    /**
     * Return model path of which to associate the added files to from config file for upload type.
     *
     * @return string
     */
    public function getModel(): string
    {
        return config('laravel-dropzone.'.$this->uploadType.'.model') ?
            config('laravel-dropzone.'.$this->uploadType.'.model') :
            config('laravel-dropzone.default.model');
    }

    /**
     * Returns max file size limit in kb from config file for upload type.
     *
     * @return string
     */
    public function getMaxFileSizeLimit(): string
    {
        return config('laravel-dropzone.'.$this->uploadType.'.max_file_size') ?
            config('laravel-dropzone.'.$this->uploadType.'.max_file_size') :
            config('laravel-dropzone.default.max_file_size');
    }

    /**
     * Remove . prefix so laravel validator can use allowed files.
     *
     * @return string
     */
    public function getAllowedFileTypes(): string
    {
        return config('laravel-dropzone.'.$this->uploadType.'.allowed_file_types') ?
            config('laravel-dropzone.'.$this->uploadType.'.allowed_file_types') :
            config('laravel-dropzone.default.allowed_file_types');
    }

    /**
     * Check if a model path has been set from config file for upload type.
     *
     * @return bool
     */
    public function hasModel(): bool
    {
        return $this->getModel() ? true : false;
    }

    /**
     * Returns an array of file validation rules.
     *
     * @return array
     */
    public function getFileValidationRules(): array
    {
        $maxFileSizeLimit = $this->formatMegabytesToBytes($this->getMaxFileSizeLimit());
        $allowedFileTypes = $this->removeDotPrefix($this->getAllowedFileTypes());
        $modelIdRules = $this->hasModel() ? 'required' : '';

        return [
            'model_id' => $modelIdRules,
            'file' => 'required|file|max:'.$maxFileSizeLimit.'|mimes:'.$allowedFileTypes,
        ];
    }
}
