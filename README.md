# Laravel Dropzone Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/danjamesmills/laravel-dropzonejs.svg?style=flat-square)](https://packagist.org/packages/danjamesmills/laravel-dropzonejs)
[![Build Status](https://img.shields.io/travis/danjamesmills/laravel-dropzonejs/master.svg?style=flat-square)](https://travis-ci.org/danjamesmills/laravel-dropzonejs)
[![Quality Score](https://img.shields.io/scrutinizer/g/danjamesmills/laravel-dropzonejs.svg?style=flat-square)](https://scrutinizer-ci.com/g/danjamesmills/laravel-dropzonejs)
[![Total Downloads](https://img.shields.io/packagist/dt/danjamesmills/laravel-dropzonejs.svg?style=flat-square)](https://packagist.org/packages/danjamesmills/laravel-dropzonejs)

Introducing our Laravel package that simplifies file uploads in Laravel using Dropzone.js on the frontend. Our package integrates Dropzone.js into the Laravel framework, providing developers with an easy-to-use drag-and-drop interface for file uploads. In addition, our package includes all necessary migrations and controllers, saving developers valuable time and effort in setting up the file upload system. With advanced features like file previews and progress bars, our package streamlines the file upload process, making it easier for both developers and users. Try it out today and simplify your file upload process in Laravel!

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

## Usage

```php
// Usage description here
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
