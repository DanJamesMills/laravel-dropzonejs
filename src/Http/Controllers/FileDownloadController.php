<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers;

use DanJamesMills\LaravelDropzone\Models\File;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileDownloadController
{
    /**
     * Download the file with the given token.
     */
    public function __invoke(string $token): StreamedResponse
    {
        $file = File::whereToken($token)->firstOrFail();

        Gate::authorize(
            'download-file',
            $file
        );

        return $file->stream();
    }
}
