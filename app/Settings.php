<?php

/**
 * Settings
 */

use Symfony\Component\VarDumper\{VarDumper, Dumper\HtmlDumper, Cloner\VarCloner};

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
    [
        VarDumper::setHandler(function ($var) {
        $cloner = new VarCloner;
        $htmlDumper = new HtmlDumper;
        $htmlDumper->setStyles([
            'default' => 'background-color:#f6f6f6; color:#222; line-height:1.3em; 
            font-weight:normal; font:16px Monaco, Consolas, monospace; 
            word-wrap: break-word; white-space: pre-wrap; position:relative; 
            z-index:100000',
            'public' => 'color:#ec9114',
            'protected' => 'color:#ec9114',
            'private' => 'color:#ec9114',
        ]);
        $htmlDumper->dump($cloner->cloneVar($var));
        })
    ]
];