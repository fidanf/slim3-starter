<?php

/**
 * Config (php, yml, json supported)
 */

return [

    'db' => [
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'port' => getenv('DB_PORT'),
        'database' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
    ],
    'twig' => [
        'debug' => getenv('APP_ENV') === 'dev',
        'cache' => getenv('APP_ENV') === 'dev' ? false : base_path('storage/cache')
    ],
    'swiftmailer' => [
        'host' => getenv('SMTP_HOST'),
        'port' => getenv('SMTP_PORT'),
        'from' => [
            'name' => getenv('SMTP_FROM_NAME'),
            'address' => getenv('SMTP_FROM_ADDRESS')
        ],
        'username' => getenv('SMTP_USERNAME'),
        'password' => getenv('SMTP_PASSWORD'),
    ],
    'redis' => [
        'host' => getenv('REDIS_HOST'),
        'port' => getenv('REDIS_PORT'),
        'password' => getenv('REDIS_PASSWORD'),
    ]
];
