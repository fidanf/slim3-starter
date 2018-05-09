<?php

use App\Controllers\Api\Articles\ArticleController as ApiArticleController;
use App\Controllers\Web\Articles\ArticleController;
use App\Controllers\Web\HomeController;
use App\Middlewares\{CsrfMiddleware, OldInputMiddleware, ValidationErrorsMiddleware};

/**
 * Web Routes
 */

$app->group('/', function() {
	$this->map(['GET', 'POST'],'', [HomeController::class, 'index'])->setName('home');
	$this->get('article', [ArticleController::class, 'list'])->setname('article.index');
	$this->get('article/{id}', [ArticleController::class, 'show'])->setname('article.show');
})->add(CsrfMiddleware::class);

/**
 * Api Routes
 */

$app->group('/api', function() {
    $this->group('/article', function () {
        $this->get('', [ApiArticleController::class, 'index']);
        $this->post('', [ApiArticleController::class, 'store']);
        $this->get('/{id:[0-9]+}', [ApiArticleController::class, 'show']);
        $this->put('/{id:[0-9]+}', [ApiArticleController::class, 'update']);
        $this->delete('/{id:[0-9]+}', [ApiArticleController::class, 'delete']);
    });
});

/**
 * Global Middlewares
 */

$app->add(ValidationErrorsMiddleware::class);
$app->add(OldInputMiddleware::class);
$app->add($container->get(\Slim\Csrf\Guard::class));

