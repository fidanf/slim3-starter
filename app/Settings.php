<?php

/**
 * Settings
 */

return [
    'settings' => [
        'settings.httpVersion' => '1.1',
        'settings.responseChunkSize' => 4096,
        'settings.outputBuffering' => 'append',
        'settings.determineRouteBeforeAppMiddleware' => true,
        'settings.displayErrorDetails' => getenv('APP_DEBUG') === 'true'
    ],
    'db' => [
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'database' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],
    'twig_config' => [
        'debug' => true,
//        'cache' => false,
        'cache' => __DIR__ . '/../cache/',
    ],
    'mail' => [
        'host' => getenv('SMTP_HOST'),
        'port' => getenv('SMTP_PORT'),
        'from' => [
            'name' => getenv('SMTP_FROM_NAME'),
            'address' => getenv('SMTP_FROM_ADDRESS')
        ],
        'username' => getenv('SMTP_USERNAME'),
        'password' => getenv('SMTP_PASSWORD'),
    ],
];