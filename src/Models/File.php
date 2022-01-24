<?php

namespace DanJamesMills\LaravelDropzone\Models;

use DanJamesMills\LaravelDropzone\Traits\FileExtension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Auth;

class File extends Model
{
    use FileExtension,
        SoftDeletes,
        LogsActivity;

    protected static $logFillable = true;

    public function tapActivity(Activity $activity, string $eventName)
    {
        $activity->description = "file.{$eventName}";
    }

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
            $file->user_id = Auth::User()->id;
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
        if (Storage::disk($this->disk)->getVisibility($this->getFullFilePathWithFilename()) == 'public') {
            return Storage::disk($this->disk)->url($this->filename);
        }
    }

    public function downloadFile()
    {
        return Storage::disk($this->disk)->download($this->getFullFilePathWithFilename(), $this->original_filename);
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
