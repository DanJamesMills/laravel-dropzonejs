<?php

namespace DanJamesMills\LaravelDropzone\Interfaces;

interface UploadSettingsInterface
{
    /**
     * Set upload type.
     *
     * @param string $uploadType
     * @return void
     * @throws \InvalidArgumentException if upload type does not exist in config file
     */
    public function setUploadType(string $uploadType): void;

    /**
     * Return which disk to use for Filesystem Disks from config file for upload type.
     *
     * @return string
     */
    public function getDisk(): string;

    /**
     * Return upload path from config file for upload type.
     *
     * @return string
     */
    public function getPath(): string;

    /**
     * Return model path of which to associate the added files to from config file for upload type.
     *
     * @return string|null
     */
    public function getModel(): ?string;

    /**
     * Returns max file size limit in kb from config file for upload type.
     *
     * @return int
     */
    public function getMaxFileSizeLimit(): int;

    /**
     * Returns an array of allowed file types from config file for upload type.
     *
     * @return array
     */
    public function getAllowedFileTypes(): array;

    /**
     * Check if a model path has been set from config file for upload type.
     *
     * @return bool
     */
    public function hasModel(): bool;

    /**
     * Returns an array of file validation rules.
     *
     * @return array
     */
    public function getFileValidationRules(): array;
}