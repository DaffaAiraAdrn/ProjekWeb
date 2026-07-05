<?php

use Illuminate\Support\InteractsWithTime;

return [

    'store' => env('CACHE_STORE', 'file'),

    'stores' => [

        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('framework/cache/data'),
            'lock_path' => storage_path('framework/cache/locks'),
        ],

        'database' => [
            'driver' => 'database',
            'table' => env('DB_CACHE_TABLE', 'cache'),
            'connection' => env('DB_CACHE_CONNECTION', env('DB_CONNECTION', 'sqlite')),
            'lock_connection' => env('DB_CACHE_LOCK_CONNECTION', env('DB_CACHE_CONNECTION', env('DB_CONNECTION', 'sqlite'))),
        ],

    ],

    'prefix' => env('CACHE_PREFIX', 'laravel_cache'),

];
