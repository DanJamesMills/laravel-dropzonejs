<?php

namespace DanJamesMills\LaravelDropzone\Models;

use Auth;
use DanJamesMills\LaravelDropzone\Events\FileCreated;
use DanJamesMills\LaravelDropzone\Events\FileDeleted;
use DanJamesMills\LaravelDropzone\Events\FileUpdated;
use DanJamesMills\LaravelDropzone\Interfaces\FileActionsInterface;
use DanJamesMills\LaravelDropzone\Traits\FileActions;
use DanJamesMills\LaravelDropzone\Traits\FileExtension;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model implements FileActionsInterface
{
    use FileExtension;
    use FileActions;
    use SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => FileCreated::class,
        'updated' => FileUpdated::class,
        'deleted' => FileDeleted::class,
    ];

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'download_url',
        'public_file_path_with_file_name',
        'file_icon',
        'format_size_units',
        'original_filename_with_file_extension',
        'type',
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
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

    /**
     * Get the owning fileable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function fileable()
    {
        return $this->morphTo('model');
    }

    /**
     * Get the user that uploaded the file.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('laravel-dropzone.user_model'));
    }

    /**
     * Get the download URL for the file.
     */
    public function getDownloadUrlAttribute(): string
    {
        return url("/file/$this->token/download");
    }

    /**
     * Get the public file path with file name.
     */
    public function getPublicFilePathWithFileNameAttribute(): ?string
    {
        if (Storage::disk($this->disk)->getVisibility($this->getFullFilePathWithFilename()) == 'public') {
            return Storage::disk($this->disk)->url($this->filename);
        }

        return null;
    }

    /**
     * Scope a query to only include pre-uploaded files.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeIsPreUpload($query)
    {
        return $query->where('is_pre_upload', true);
    }

    /**
     * Scope a query to only include files that are not in a folder.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNoFolder($query)
    {
        return $query->whereNull('file_folder_id');
    }

    /**
     * Scope a query to only include files with a specific folder ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query The database query builder instance.
     * @param int $folderId The ID of the folder to filter by.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFolderId($query, int $folderId)
    {
        return $query->where('file_folder_id', $folderId);
    }

    /**
     * Get the formatted file size.
     */
    public function getFormatSizeUnitsAttribute(): string
    {
        $i = floor(log($this->size, 1024));

        return round($this->size / pow(1024, $i), [0, 0, 2, 2, 3][$i]).' '.['B', 'KB', 'MB', 'GB', 'TB'][$i];
    }

    /**
     * Get the original filename with the file extension.
     */
    public function getOriginalFilenameWithFileExtensionAttribute(): string
    {
        return $this->original_filename.'.'.$this->file_extension;
    }

    /**
     * Get the type of the file.
     */
    public function getTypeAttribute(): string
    {
        return 'File';
    }
}
