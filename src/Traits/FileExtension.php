<?php

namespace DanJamesMills\LaravelDropzone\Traits;

use Illuminate\Support\Arr;

trait FileExtension
{
    public function getFileIconAttribute(): string
    {
        $defaultExtensions = [
            'ai' => 'ai.svg',
            'html' => 'html.svg',
            'pdf' => 'pdf.svg',
            'xls' => 'xls.svg',
            'xlsx' => 'xls.svg',
            'csv' => 'csv.svg',
            'docx' => 'doc.svg',
            'zip' => 'zip.svg',
            'mp3' => 'mp3.svg',
            'mp4' => 'mp4.svg',
            'wav' => 'wav.svg',
            'jpg' => 'jpg.svg',
            'jpeg' => 'jpg.svg',
            'png' => 'png.svg',
            'bmp' => 'bmp.svg',
            'txt' => 'txt.svg',
            'avi' => 'avi.svg',
            'indd' => 'indd.svg',
            'eps' => 'eps.svg',
            'ppt' => 'ppt.svg',
            'pptx' => 'ppt.svg',
            'psd' => 'psd.svg',
            'msg' => 'msg.svg',
            'htm' => 'html.svg',
        ];

        $additionalExtensions = config('laravel-dropzone.file_extensions', []);
        $extensions = array_merge($defaultExtensions, $additionalExtensions);

        $iconUrlPath = config('laravel-dropzone.file_extension_icon_url_path', 'images/icons') . '/';

        $extension = strtolower($this->file_extension);

        return $iconUrlPath . Arr::get($extensions, $extension, 'txt.svg');

    }
}
