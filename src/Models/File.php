<?php

namespace DanJamesMills\LaravelDropzone\Models;

use DanJamesMills\LaravelDropzone\Traits\FileExtension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class File extends Model
{
    use FileExtension;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $appends = [
        'downloadUrl',
        'publicFilePathWithFileName',
        'file_icon',
        'formatSizeUnits',
        'type'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($file) {
            $file->user_id = Auth::id();
            $file->token = \Str::uuid();
        });

        static::deleting(function ($file) {
            if ($file->forceDeleting) {
                Storage::disk($file->disk)
                    ->delete($file->getFullFilePathWithFilename());
            }
        });
    }

    public function fileable()
    {
        return $this->morphTo('model');
    }

    /**
     * The creator of the file.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
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
        // if (Storage::disk($this->disk)->getVisibility($this->getFullFilePathWithFilename()) == 'public') {
        //     return Storage::disk($this->disk)->url($this->filename);
        // }
    }

    public function downloadFile()
    {
        return Storage::disk($this->disk)->download($this->getFullFilePathWithFilename(), $this->original_filename);
    }

    public function previewFile()
    {
        return response(Storage::disk($this->disk)->get($this->getFullFilePathWithFilename()), 200)
            ->header('Content-Type', $this->mime_type)
            ->header('Content-Disposition', 'inline; filename="'.$this->original_filename.'"');
    }

    public function getFormatSizeUnitsAttribute()
    {
        $i = floor(log($this->size, 1024));

        return round($this->size / pow(1024, $i), [0, 0, 2, 2, 3][$i]) . ' ' . ['B', 'KB', 'MB', 'GB', 'TB'][$i];
    }

    public function getTypeAttribute()
    {
        return 'File';
    }
}
