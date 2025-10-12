<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Ubah default dari "local" ke "public" agar file bisa diakses dari browser.
    | Dengan ini, semua upload (termasuk foto profil) otomatis masuk ke disk publik.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk berbagai driver penyimpanan.
    | Disini sudah tersedia "local", "public", dan "s3".
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        // Disk lokal, khusus untuk file internal (tidak untuk publik)
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        // Disk publik — digunakan untuk file yang bisa diakses lewat browser
        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        // Disk S3 — contoh untuk cloud storage (AWS)
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Link simbolik agar folder "public/storage" bisa mengakses "storage/app/public".
    | Pastikan sudah menjalankan perintah:
    | php artisan storage:link
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
