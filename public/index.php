<?php

session_start();

date_default_timezone_set('Europe/Paris');
setlocale (LC_TIME, 'fr_FR.utf8','fra');

require __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    die($e);
}

require_once __DIR__ . './../app/Helpers.php';

$config = require_once __DIR__ . './../app/config.php';

$app = new \App\App($config);
$container = $app->getContainer();


require_once __DIR__ . '/../app/Routes.php';

$app->run();