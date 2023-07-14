# Laravel Dropzone Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danjamesmills/laravel-dropzonejs.svg?style=flat-square)](https://packagist.org/packages/danjamesmills/laravel-dropzonejs)
[![Build Status](https://img.shields.io/travis/danjamesmills/laravel-dropzonejs/master.svg?style=flat-square)](https://travis-ci.org/danjamesmills/laravel-dropzonejs)
[![Quality Score](https://img.shields.io/scrutinizer/g/danjamesmills/laravel-dropzonejs.svg?style=flat-square)](https://scrutinizer-ci.com/g/danjamesmills/laravel-dropzonejs)
[![Total Downloads](https://img.shields.io/packagist/dt/danjamesmills/laravel-dropzonejs.svg?style=flat-square)](https://packagist.org/packages/danjamesmills/laravel-dropzonejs)

Experience the Laravel Dropzone package – a comprehensive tool that blends Dropzone.js with Laravel, delivering effortless file management.

Experience the Laravel Dropzone package – a comprehensive tool that blends Dropzone.js with Laravel, delivering effortless file management.

🔧 Quick and Easy Setup: Comes with ready-to-use views, migrations, and controller endpoints to get you up and running swiftly.
🎛️ Customisable: Tailor your upload types, acceptable file sizes, and file types to match your precise needs.
🗂️ Organised File Management: Supports categorisation of files into folders, helping you maintain a well-organised file system.
🛡️ Folder Permissions: Set permissions on your folders to control accessibility - select from 'anyone', 'only you', or 'any with the link'.
📂 Pre-upload Capability: Pre-upload files and effortlessly associate them with the appropriate model upon save for a seamless user experience.
☁️ Multiple Storage Options: Upload files to any supported Laravel file driver, expanding your storage possibilities.
📑 Meta-data Storage: Retains file metadata in the database for quick and convenient retrieval.
🎯 Straightforward and Efficient: Crafted for simplicity and efficacy, it streamlines your Laravel file management.
Explore the efficiency of Laravel Dropzone today!

## Installation

You can install the package via composer:

```bash
composer require danjamesmills/laravel-dropzonejs
```

## Publish Config

You should publish the migration and the config/laravel-dropzone.php config file with:

```php
php artisan vendor:publish --provider="DanJamesMills\LaravelDropzone\LaravelDropzoneServiceProvider"
```

Run the migrations: After the config and migration have been published and configured, you can create the tables for this package by running:

```php
php artisan migrate
```

### Preparing your model

To associate files with a model, the model must implement the following trait:

```php
use DanJamesMills\LaravelDropzone\Traits\HasFile;

class Post extends Model
{
    use HasFile;

    // ...
}
```

### Defining Upload Types

In your laravel-dropzone.php configuration file, you'll need to establish your desired upload types. Follow the example below for guidance on structuring your own upload types:

```php
    'post' => [

        /*
         * The disk on which to store added files. Choose one of the
         * disks you've configured in config/filesystems.php.
         */

        'disk' => 's3',

        /*
         * The path on the disk on which to store added files to.
         */

        'path' => '/posts/',

        /*
         * The model path of which to associate the added files to.
         */

        'model' => App\Models\Post::class,

        /*
        * This setting allows files to be uploaded prior to the model being saved/created.
        * These pre-uploaded files can then be associated with the newly created model on save.
        */
        'allow_pre_upload' => true,

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
        * The maximum file size of an item in bytes.
        */
        'max_file_size' => 1024 * 1024 * 10,
    ]
```

## Usage

```php
Take full advantage of the Laravel Dropzone package with the following simple steps:

1. Direct your file uploads to the API endpoint: `api/v1/uploader`. This endpoint is configured to handle all your file upload needs.

2. Ensure to include mandatory fields such as `file` and `upload_type` in your POST request to this endpoint. These details inform the package about the file type and the suitable handling procedure.

3. Optionally, you can specify the `model_id` and `folder_id` fields in your request. If `model_id` is provided, the file will be automatically linked with the corresponding model upon saving the file. Likewise, using `folder_id` will help you organise your files into a specific folder.


```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email daniel620@hotmail.co.uk instead of using the issue tracker.

## Credits

-   [Daniel Mills](https://github.com/danjamesmills)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
