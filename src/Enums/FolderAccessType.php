<?php

namespace DanJamesMills\LaravelDropzone\Enums;

enum FolderAccessType:int
{
    case ACCESS_TYPE_ANYONE = 1;
    case ACCESS_TYPE_ONLY_YOU = 2;
    case ACCESS_TYPE_SPECIFIC_USERS = 3;

    public static function getAllValues(): array
    {
        return array_column(FolderAccessType::cases(), 'value');
    }
}
