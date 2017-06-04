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
        'settings.displayErrorDetails' => true,
    ],
    'db' => [
        'driver' => "{$_ENV['DB_DRIVER']}",
        'host' => "{$_ENV['DB_HOST']}",
        'database' => "{$_ENV['DB_NAME']}",
        'username' => "{$_ENV['DB_USER']}",
        'password' => "{$_ENV['DB_PASSWORD']}",
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],
    'twig_config' => [
        'debug' => true,
        'cache' => false,
    ],
];