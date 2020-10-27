<?php

return [

    /*
         * Below are the default settings the package will use.
         * Please feel free to change these settings, but please
         * do not delete these as they are used as defaults if no other settings
         * are specified on the individual upload types below.
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
         * By default all files uploaded will validate against the below allowed file types.
         * When passing in allowed file types be sure to remove the "." i.e pdf
         * and separate each file type with a comma.
         */

        'allowed_file_types' => '.pdf,.doc,.xls,.docx,.xlsx,.jpg,.png,.gif,.jpeg',

        /*
         * The maximum file size of an file in megabytes.
         */

        'max_file_size' => 250, // 250 MB

    ],

    /*
     * Below are upload types, you can create as many upload types as you wish.
     * A upload type defines individual settings for how file uploads should be handled.
     * You might have a tasks system that needs to only accept 5MB files and only jpg, png files.
     * On the other hand you might have a CRM system that needs to accept 2MB files and store
     * them on AWS S3.
     *
     * When specifying individual upload types you do not need to include all the settings, if you don't
     * provide say "max_file_size" it will use the default settings.
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
         * A comma separated string containing allowed file type extensions.
         */

        'allowed_file_types' => '.pdf,.doc,.xls,.csv,.docx,.xlsx,.jpg,.png,.gif,.jpeg,.zip',

        /*
         * The maximum file size of a file in megabytes.
         */

        'max_file_size' => 50, // 50 MB
    ],

];
