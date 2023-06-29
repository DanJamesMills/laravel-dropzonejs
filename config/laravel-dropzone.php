<?php

return [

    /*
     * The model to use for files.
     */
    'file_model' => \DanJamesMills\LaravelDropzone\Models\File::class,

    /*
     * The model to use for file folders.
     */
    'file_folder_model' => \DanJamesMills\LaravelDropzone\Models\FileFolder::class,

    /*
     * This is the Auth model used by files.
     */
    'user_model' => \App\Models\User::class,

    /*
     * Whether to automatically create API comment endpoints.
     * If this is false, you can still set up routing manually.
     */
    'autoload' => true,

    /*
     * Middleware to attach to the comments endpoint (if `autoload` is true).
     */
    'api_middleware' => ['api', 'auth:sanctum'],

    /*
     * The prefix to use for the API comment endpoints.
     */
    'api_prefix' => 'api/v1',

    /**
     * You can customise the behavior of these permissions by
     * creating your own and pointing to it here.
     */
    'permissions' => [
        'view-any-file' => \DanJamesMills\LaravelDropzone\Policies\FilePolicy::class . '@viewAny',
        'view-file' => \DanJamesMills\LaravelDropzone\Policies\FilePolicy::class . '@view',
        'upload-file' => \DanJamesMills\LaravelDropzone\Policies\FilePolicy::class . '@create',
        'download-file' => \DanJamesMills\LaravelDropzone\Policies\FilePolicy::class . '@download',
        'update-file' => \DanJamesMills\LaravelDropzone\Policies\FilePolicy::class . '@update',
        'delete-file' => \DanJamesMills\LaravelDropzone\Policies\FilePolicy::class . '@delete',
        'access-all-folders' => \DanJamesMills\LaravelDropzone\Policies\FileFolderPolicy::class . '@viewAny',
        'view-file-folder' => \DanJamesMills\LaravelDropzone\Policies\FileFolderPolicy::class . '@view',
        'create-file-folder' => \DanJamesMills\LaravelDropzone\Policies\FileFolderPolicy::class . '@create',
        'update-file-folder' => \DanJamesMills\LaravelDropzone\Policies\FileFolderPolicy::class . '@update',
        'delete-file-folder' => \DanJamesMills\LaravelDropzone\Policies\FileFolderPolicy::class . '@delete',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Upload Settings
    |--------------------------------------------------------------------------
    |
    | These are the default settings that the package will use. You are free
    | to modify them as needed, but please do not delete them as they are
    | used as defaults if no other settings are specified on the individual
    | upload types below.
    |
    */

    'default' => [

        /*
         * The disk on which to store added files. Choose one of the
         * disks you've configured in config/filesystems.php.
         */

        'disk' => 'public',

        /*
         * The path on the disk on which to store added files to.
         */

        'path' => '/uploads',

        /*
         * The model path of which to associate the added files to.
         */

        'model' => '',

        /*
         * By default, all files uploaded will validate against the following allowed file types.
         */

        'allowed_file_types' => [
            'pdf',
            'doc',
            'xls',
            'csv',
            'docx',
            'xlsx',
            'jpg',
            'png',
            'gif',
            'jpeg',
            'zip',
        ],

        /*
         * The maximum file size of a file in megabytes.
         */

        'max_file_size_mb' => 250,

    ],

    /*
    |--------------------------------------------------------------------------
    | Upload Types
    |--------------------------------------------------------------------------
    |
    | Below are upload types, which define individual settings for how file
    | uploads should be handled. You can create as many upload types as you wish.
    | For example, you might have a tasks system that needs to only accept 5MB
    | files and only jpg, png files. On the other hand, you might have a CRM system
    | that needs to accept 2MB files and store them on AWS S3.
    |
    | When specifying individual upload types, you do not need to include all
    | the settings. If you don't provide a setting, it will use the default
    | settings.
    |
    */

    'contact' => [

        /*
         * The disk on which to store added files. Choose one of the
         * disks you've configured in config/filesystems.php.
         */

        'disk' => 'public',

        /*
         * The path on the disk on which to store added files to.
         */

        'path' => '/contact/files/',

        /*
         * The model path of which to associate the added files to.
         */

        'model' => App\Models\Contact::class,

        /*
         * An array containing allowed file type extensions.
         */

        'allowed_file_types' => [
            'pdf',
            'doc',
            'xls',
            'csv',
            'docx',
            'xlsx',
            'jpg',
            'png',
            'gif',
            'jpeg',
            'zip',
        ],

        /*
         * The maximum file size of a file in megabytes.
         */

        'max_file_size_mb' => 50,
    ],

];
