<?php

namespace DanJamesMills\LaravelDropzone\Models\Traits;

trait FileExtension
{
    public function getFileIconAttribute()
    {
        switch ($this->extension) {
        case 'pdf':
            $data['icon'] = 'far fa-file-pdf';
            $data['color'] = '#E83E34';
            break;
        case 'xlsx':
        case 'csv':
            $data['icon'] = 'far fa-file-excel';
            $data['color'] = '#0D7037';
            break;
        case 'docx':
            $data['icon'] = 'far fa-file-word';
            $data['color'] = '#0F3C8D';
            break;
        case 'zip':
            $data['icon'] = 'far fa-file-archive';
            $data['color'] = '#F5B730';
            break;
        case 'mp3':
        case 'wav':
            $data['icon'] = 'far fa-file-audio';
            $data['color'] = '#BD1FF2';
            break;
        case 'jpg':
        case 'png':
        case 'gif':
            $data['icon'] = 'far fa-file-image';
            $data['color'] = '#F76D00';
            break;
        default:
            $data['icon'] = 'far fa-file-alt';
            $data['color'] = '#5A6167';
        }

        return $data;
    }
}
