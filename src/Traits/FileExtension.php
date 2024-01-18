<?php

namespace DanJamesMills\LaravelDropzone\Traits;

use Illuminate\Support\Arr;

trait FileExtension
{
    public function getFileIconAttribute(): string
    {
        $defaultExtensions = [
            'aac' => 'aac.svg',
            'ai' => 'ai.svg',
            'avi' => 'avi.svg',
            'bmp' => 'bmp.svg',
            'cad' => 'cad.svg',
            'csv' => 'csv.svg',
            'doc' => 'doc.svg',
            'docx' => 'doc.svg',
            'eps' => 'eps.svg',
            'flac' => 'flac.svg',
            'gif' => 'gif.svg',
            'heic' => 'heic.svg',
            'html' => 'html.svg',
            'indd' => 'indd.svg',
            'jpg' => 'jpg.svg',
            'jpeg' => 'jpg.svg',
            'm4a' => 'm4a.svg',
            'mov' => 'mov.svg',
            'mp3' => 'mp3.svg',
            'mp4' => 'mp4.svg',
            'msg' => 'msg.svg',
            'ogg' => 'ogg.svg',
            'pdf' => 'pdf.svg',
            'png' => 'png.svg',
            'ppt' => 'ppt.svg',
            'pptx' => 'ppt.svg',
            'psd' => 'psd.svg',
            'raw' => 'raw.svg',
            'svg' => 'svg.svg',
            'tif' => 'tif.svg',
            'tiff' => 'tiff.svg',
            'txt' => 'txt.svg',
            'wav' => 'wav.svg',
            'xls' => 'xls.svg',
            'xlsx' => 'xls.svg',
            'zip' => 'zip.svg',
        ];

        $additionalExtensions = config('laravel-dropzone.file_extensions', []);
        $extensions = array_merge($defaultExtensions, $additionalExtensions);

        $iconUrlPath = config('laravel-dropzone.file_extension_icon_url_path', 'images/icons') . '/';

        $extension = strtolower($this->file_extension);

        return $iconUrlPath . Arr::get($extensions, $extension, 'txt.svg');

    }
}
