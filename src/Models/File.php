<?php

namespace DanJamesMills\LaravelDropzone\Models;

use DanJamesMills\LaravelDropzone\Models\Traits\FileExtension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use FileExtension;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $appends = ['downloadUrl', 'publicFilePathWithFileName', 'fileIcon', 'formatSizeUnits'];

    public function fileable()
    {
        return $this->morphTo();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {

            // delete associated file from storage
            Storage::disk($file->disk)->delete($file->getFullFilePathWithFilename());
        });
    }

    public function getDownloadUrlAttribute()
    {
        return env('APP_URL').'/file/'.$this->token.'/download';
    }

    public function getFullFilePathWithFilename()
    {
        return $this->path.'/'.$this->storage_filename;
    }

    public function getPublicFilePathWithFileNameAttribute()
    {
        return Storage::disk($this->disk)->url($this->filename);
    }

    public function downloadFile()
    {
        return Storage::disk($this->disk)->download($this->getFullFilePathWithFilename(), $this->original_filename);
    }

    public function getFormatSizeUnitsAttribute()
    {
        $i = floor(log($this->size, 1024));

        return round($this->size / pow(1024, $i), [0, 0, 2, 2, 3][$i]).['B', 'KB', 'MB', 'GB', 'TB'][$i];
    }
}
