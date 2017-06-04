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

use App\Middlewares\{CsrfMiddleware, OldInputMiddleware, ValidationErrorsMiddleware};
use Respect\Validation\Validator;

$app->add(ValidationErrorsMiddleware::class);
$app->add(OldInputMiddleware::class);
$app->add(CsrfMiddleware::class);
$app->add($container->get(\Slim\Csrf\Guard::class));
Validator::with("App\Validation\Rules");