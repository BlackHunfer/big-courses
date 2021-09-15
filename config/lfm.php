<?php

/*
|--------------------------------------------------------------------------
| Documentation for this config :
|--------------------------------------------------------------------------
| online  => http://unisharp.github.io/laravel-filemanager/config
| offline => vendor/unisharp/laravel-filemanager/docs/config.md
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Routing
    |--------------------------------------------------------------------------
     */

    'use_package_routes'       => true,

    /*
    |--------------------------------------------------------------------------
    | Shared folder / Private folder
    |--------------------------------------------------------------------------
    |
    | If both options are set to false, then shared folder will be activated.
    |
     */

    'allow_private_folder'     => true,

    // Flexible way to customize client folders accessibility
    // If you want to customize client folders, publish tag="lfm_handler"
    // Then you can rewrite userField function in App\Handler\ConfigHandler class
    // And set 'user_field' to App\Handler\ConfigHandler::class
    // Ex: The private folder of user will be named as the user id.
    'private_folder_name'      => UniSharp\LaravelFilemanager\Handlers\ConfigHandler::class,

    'allow_shared_folder'      => false,

    'shared_folder_name'       => 'shares',

    /*
    |--------------------------------------------------------------------------
    | Folder Names
    |--------------------------------------------------------------------------
     */

    'folder_categories'        => [
        'file'  => [
            'folder_name'  => 'files',
            'startup_view' => 'list',
            'max_size'     => 10256, // size in KB
            'valid_mime'   => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
                'application/pdf',
                'application/zip',
                'application/octet-stream', 
                'application/x-zip-compressed', 
                'multipart/x-zip',
                'application/x-7z-compressed',
                'application/x-rar-compressed',
                'application/vnd.rar',
                'application/msword',
                'application/docx',
                'application/DOCX',
                'image/vnd.microsoft.icon', 
                'image/x-icon',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                'application/vnd.ms-word.document.macroEnabled.12',
                'application/vnd.ms-word.template.macroEnabled.12',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel.sheet.macroEnabled.12',
                'application/vnd.ms-excel.template.macroEnabled.12',
                'application/vnd.ms-excel.addin.macroEnabled.12',
                'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
                'application/vnd.ms-powerpoint',
                'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/vnd.openxmlformats-officedocument.presentationml.template',
                'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
                'application/vnd.ms-powerpoint.addin.macroEnabled.12',
                'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
                'application/vnd.ms-powerpoint.template.macroEnabled.12',
                'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
                'application/vnd.ms-access',
                'application/vnd.ms-excel',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ],
        ],
        'image' => [
            'folder_name'  => 'photos',
            'startup_view' => 'grid',
            'max_size'     => 5256, // size in KB
            'valid_mime'   => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'image/svg+xml',
            ],
        ],
        'video' => [
            'folder_name'  => 'video',
            'startup_view' => 'grid',
            'max_size'     => 10256, // size in KB
            'valid_mime'   => [
                'video/mp4',
                'video/webm',
                'video/mpeg',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
     */

    'paginator' => [
        'perPage' => 30,
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload / Validation
    |--------------------------------------------------------------------------
     */

    'disk'                     => 'public',

    'rename_file'              => false,

    'rename_duplicates'        => true,

    'alphanumeric_filename'    => false,

    'alphanumeric_directory'   => false,

    'should_validate_size'     => true,
    // 'max_image_size'           => ,

    'should_validate_mime'     => true,

    'allow_multi_user'         => true,

    // behavior on files with identical name
    // setting it to true cause old file replace with new one
    // setting it to false show `error-file-exist` error and stop upload
    'over_write_on_duplicate'  => false,

    'max_file_size'            => 10256,

    /*
    |--------------------------------------------------------------------------
    | Thumbnail
    |--------------------------------------------------------------------------
     */

    // If true, image thumbnails would be created during upload
    'should_create_thumbnails' => true,

    'thumb_folder_name'        => 'thumbs',

    // Create thumbnails automatically only for listed types.
    'raster_mimetypes'         => [
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif',
        'image/svg+xml',
    ],

    'thumb_img_width'          => 200, // px

    'thumb_img_height'         => 200, // px

    /*
    |--------------------------------------------------------------------------
    | File Extension Information
    |--------------------------------------------------------------------------
     */

    'file_type_array'          => [
        'pdf'  => 'Adobe Acrobat',
        'doc'  => 'Microsoft Word',
        'docx' => 'Microsoft Word',
        'otf'  => 'OpenType font',
        'xls'  => 'Microsoft Excel',
        'xlsx' => 'Microsoft Excel',
        'zip'  => 'Archive',
        '7z'   => 'Archive',
        'rar'  => 'Archive',
        'gif'  => 'GIF Image',
        'jpg'  => 'JPEG Image',
        'jpeg' => 'JPEG Image',
        'png'  => 'PNG Image',
        'ppt'  => 'Microsoft PowerPoint',
        'pptx' => 'Microsoft PowerPoint',
        'mp4' => 'Video MP4',
        'webm' => 'Video WEBM'
    ],

    /*
    |--------------------------------------------------------------------------
    | php.ini override
    |--------------------------------------------------------------------------
    |
    | These values override your php.ini settings before uploading files
    | Set these to false to ingnore and apply your php.ini settings
    |
    | Please note that the 'upload_max_filesize' & 'post_max_size'
    | directives are not supported.
     */
    'php_ini_overrides'        => [
        'memory_limit' => '256M',
    ],
];
