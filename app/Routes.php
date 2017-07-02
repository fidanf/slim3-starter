<?php

use App\Controllers\Articles\ArticleController;
use App\Controllers\HomeController;
use App\Middlewares\{CsrfMiddleware, OldInputMiddleware, ValidationErrorsMiddleware};
use Respect\Validation\Validator;

/**
 * Web Routes
 */

$app->group('/', function () {
	$this->map(['GET', 'POST'],'', [HomeController::class, 'index'])->setName('home');
})->add(CsrfMiddleware::class);

/**
 * Api Routes
 */
$app->group('/api', function() {
    $this->group('/article', function () {
        $this->get('', [ArticleController::class, 'index']);
        $this->post('', [ArticleController::class, 'store']);
        $this->get('/{id:[0-9]+}', [ArticleController::class, 'show']);
        $this->delete('/{id:[0-9]+}', [ArticleController::class, 'delete']);
    });
});

/**
 * Global Middlewares
 */
$app->add(ValidationErrorsMiddleware::class);
$app->add(OldInputMiddleware::class);
$app->add($container->get(\Slim\Csrf\Guard::class));
Validator::with("App\Validation\Rules");