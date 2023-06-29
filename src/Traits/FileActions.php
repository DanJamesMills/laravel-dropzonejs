<?php

namespace DanJamesMills\LaravelDropzone\Traits;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait FileActions
{
    /**
     * Get the full file path with filename.
     *
     * @return string
     */
    public function getFullFilePathWithFilename(): string
    {
        return $this->path.'/'.$this->storage_filename;
    }

    /**
     * Download the file.
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        return Storage::disk($this->disk)
            ->download($this->getFullFilePathWithFilename(), $this->original_filename_with_file_extension);
    }

    /**
     * Stream the file.
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function stream(): StreamedResponse
    {
        $fileStream = Storage::disk($this->disk)->readStream($this->getFullFilePathWithFilename());

        return new StreamedResponse(function () use ($fileStream) {
            fpassthru($fileStream);
        }, 200, [
            'Content-Type' => $this->mime_type,
            'Content-Disposition' => 'inline; filename="' . $this->original_filename_with_file_extension . '"'
        ]);
    }
}