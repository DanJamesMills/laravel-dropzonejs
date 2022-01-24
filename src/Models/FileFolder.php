<?php

namespace DanJamesMills\LaravelDropzone\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Auth;

class FileFolder extends Model
{
    use SoftDeletes;

    const ACCESS_TYPE_ANYONE = 1;
    const ACCESS_TYPE_ONLY_YOU = 2;
    const ACCESS_TYPE_SPECIFIC_USERS = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $with = [
        'users'
    ];

    protected $appends = [
        'type'
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($fileFolder) {
            $fileFolder->user_id = Auth::User()->id;
        });

        static::deleting(function ($fileFolder) {
            foreach ($fileFolder->subfolders as $subfolder) {
                $subfolder->files()->delete();
                $subfolder->delete();
            }
        });
    }

    /**
     * The creator of the file folder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get all users that can access folder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'file_folder_user')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function files()
    {
        return $this->hasMany(\DanJamesMills\LaravelDropzone\Models\File::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function parent()
    {
        return $this->hasOne(self::class, 'id', 'parent_file_folder_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function subfolders()
    {
        return $this->hasMany(self::class, 'parent_file_folder_id', 'id');
    }


    public function getAllParentFolders()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    public function getRootPath()
    {
        return $this->getAllParentFolders()->map(function ($folder) {
            return [
                'id' => $folder->id,
                'name' => $folder->name
            ];
        });
    }

    /**
     * Check if user has access to folder.
     *
     * @param integer|null $userId
     *
     * @return boolean
     */
    public function hasAccessToFolder(int $userId = null): bool
    {
        $userId = ($userId) ? $userId : Auth::id();

        if ($this->access_type == self::ACCESS_TYPE_ANYONE) {
            return true;
        } elseif ($this->access_type == self::ACCESS_TYPE_ONLY_YOU) {
            return $this->checkIfIOwnFolder();
        } else {
            return $this->checkIfUserIsInFolderAccessList($userId);
        }
    }

    /**
     * Check if user is in folder access list.
     *
     * @param integer|null $userId
     *
     * @return boolean
     */
    public function checkIfUserIsInFolderAccessList(int $userId): bool
    {
        return $this->users->contains('id', $userId);
    }

    /**
     * Check if I own the folder.
     *
     * @return boolean
     */
    public function checkIfIOwnFolder(): bool
    {
        return $this->user_id == Auth::id();
    }

    public function getTypeAttribute()
    {
        return 'Folder';
    }
}
