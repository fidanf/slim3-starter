<?php 

$app->group('/', function () {
	$this->get('', ['\App\Controllers\HomeController', 'index'])->setName('home');
	$this->post('', ['\App\Controllers\HomeController', 'index']);
});

$app->add(\App\Middlewares\CsrfMiddleware::class);
$app->add($container->get(\Slim\Csrf\Guard::class));