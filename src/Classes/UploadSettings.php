<?php

namespace DanJamesMills\LaravelDropzone\Classes;

use DanJamesMills\LaravelDropzone\Interfaces\UploadSettingsInterface;

class UploadSettings implements UploadSettingsInterface
{
    /**
     * The upload type of which config we should use.
     *
     * @var string
     */
    private $uploadType;

    /**
     * UploadSettings constructor.
     *
     * @param string|null $uploadType
     * @throws \InvalidArgumentException
     */
    public function __construct(?string $uploadType = null)
    {
        $this->setUploadType($uploadType);
    }

    /**
     * Set upload type.
     *
     * @param string $uploadType
     * @throws \InvalidArgumentException
     */
    public function setUploadType(string $uploadType): void
    {
        $this->uploadType = $uploadType;

        if (!config()->has('laravel-dropzone.' . $uploadType)) {
            throw new \InvalidArgumentException('Upload Type does not exist in config/laravel-dropzone.php config file.');
        }
    }

    /**
     * Return which disk to use for Filesystem Disks from config file for upload type.
     *
     * @return string
     */
    public function getDisk(): string
    {
        return config('laravel-dropzone.' . $this->uploadType . '.disk', config('laravel-dropzone.default.disk'));
    }

    /**
     * Return upload path from config file for upload type.
     *
     * @return string
     */
    public function getPath(): string
    {
        return config('laravel-dropzone.' . $this->uploadType . '.path', config('laravel-dropzone.default.path'));
    }

    /**
     * Return model path of which to associate the added files to from config file for upload type.
     *
     * @return string|null
     */
    public function getModel(): ?string
    {
        return config('laravel-dropzone.' . $this->uploadType . '.model', config('laravel-dropzone.default.model'));
    }

    /**
     * Returns max file size limit in bytes from config file for upload type.
     *
     * @return int
     */
    public function getMaxFileSizeLimit(): int
    {
        return config('laravel-dropzone.' . $this->uploadType . '.max_file_size', config('laravel-dropzone.default.max_file_size'));
    }

    /**
     * Returns an array of allowed file types from config file for upload type.
     *
     * @return array
     */
    public function getAllowedFileTypes(): array
    {
        return config('laravel-dropzone.' . $this->uploadType . '.allowed_file_types', config('laravel-dropzone.default.allowed_file_types'));
    }

    /**
     * Check if a model path has been set from config file for upload type.
     *
     * @return bool
     */
    public function hasModel(): bool
    {
        return !is_null($this->getModel());
    }

    /**
     * Returns an array of file validation rules.
     *
     * @return array
     */
    public function getFileValidationRules(): array
    {
        return [
            'model_id' => 'numeric',
            'file' => 'required|file|max:' . $this->getMaxFileSizeLimit() . '|mimes:' . implode(',', $this->getAllowedFileTypes()),
        ];
    }
}
