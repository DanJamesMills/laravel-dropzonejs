<?php

namespace DanJamesMills\LaravelDropzone\Interfaces;

use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileActionsInterface
{
    /**
     * Get the full file path with filename.
     *
     * @return string
     */
    public function getFullFilePathWithFilename(): string;

    /**
     * Download the file.
     *
     * @return \Illuminate\Http\Response
     */
    public function download();

    /**
     * Stream the file.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function stream(): StreamedResponse;
}