<?php

/**
 * Routes
 */

$app->group('/', function () {
	$this->get('', ['\App\Controllers\HomeController', 'index'])->setName('home');
	$this->post('', ['\App\Controllers\HomeController', 'index']);
});

/**
 * Middlewares
 */

$app->add(\App\Middlewares\ValidationErrorsMiddleware::class);
$app->add(\App\Middlewares\OldInputMiddleware::class);
$app->add(\App\Middlewares\CsrfMiddleware::class);
$app->add($container->get(\Slim\Csrf\Guard::class));