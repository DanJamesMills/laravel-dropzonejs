<?php

namespace DanJamesMills\LaravelDropzone\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;
use DanJamesMills\LaravelDropzone\Models\File;
use Illuminate\Support\Facades\Gate;

class FileDownloadController
{
    /**
     * Download the file with the given token.
     *
     * @param string $token
     * @return StreamedResponse
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
