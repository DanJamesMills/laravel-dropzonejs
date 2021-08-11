<?php

namespace DanJamesMills\LaravelDropzone\Models\Traits;

trait FileExtension
{
    public function getFileIconAttribute()
    {
        switch ($this->file_extension) {
            case 'ai':
                return 'ai.svg';
            case 'html':
                return 'html.svg';
            case 'pdf':
                return 'pdf.svg';
            case 'xls':
            case 'xlsx':
                return 'xls.svg';
            case 'csv':
                return 'csv.svg';
            case 'docx':
                return 'doc.svg';
            case 'zip':
                return 'zip.svg';
            case 'mp3':
                return 'mp3.svg';
            case 'mp4':
                return 'mp4.svg';
            case 'wav':
                return 'wav.svg';
            case 'jpg':
            case 'jpeg':
                return 'jpg.svg';
            case 'jpeg':
                return 'jpg.svg';
            case 'png':
                return 'png.svg';
            case 'bmp':
                return 'bmp.svg';
            case 'txt':
                return 'txt.svg';
            case 'avi':
                return 'avi.svg';
            case 'txt':
                return 'txt.svg';
            case 'indd':
                return 'indd.svg';
            case 'eps':
                return 'eps.svg';
            case 'ppt':
            case 'pptx':
                return 'ppt.svg';
            case 'psd':
                return 'psd.svg';
            case 'msg':
                return 'msg.svg';
            case 'html':
            case 'htm':
                return 'html.svg';
            default:
                return 'txt.svg';
        }
    }
}
