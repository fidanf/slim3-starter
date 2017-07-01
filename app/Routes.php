<?php

use App\Controllers\Articles\ArticleController;
use App\Controllers\HomeController;
use App\Middlewares\{CsrfMiddleware, OldInputMiddleware, ValidationErrorsMiddleware};
use Respect\Validation\Validator;

/**
 * Routes
 */

$app->group('/', function () {
	$this->map(['GET', 'POST'],'', [HomeController::class, 'index'])->setName('home');
});

$app->group('/article', function () {
   $this->get('', [ArticleController::class, 'index']);
   $this->get('/{id:[0-9]+}', [ArticleController::class, 'show']);
});

/**
 * Middlewares
 */

$app->add(ValidationErrorsMiddleware::class);
$app->add(OldInputMiddleware::class);
$app->add(CsrfMiddleware::class);
$app->add($container->get(\Slim\Csrf\Guard::class));
Validator::with("App\Validation\Rules");