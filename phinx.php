<?php

require __DIR__ . './vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    die($e);
}

$config = require_once __DIR__ . '/app/Config.php';

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/app/Database/Migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/app/Database/Seeds'
    ],
    'migration_base_class' => 'App\Support\Migrations\Migration',
    'templates' => [
        'file' => '%%PHINX_CONFIG_DIR%%/app/Support/Migrations/MigrationStub.php.dist'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default' => [
            'adapter' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'port' => getenv('DB_PORT'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASSWORD'),
        ]
    ]
];