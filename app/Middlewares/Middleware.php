<?php


namespace App\Middlewares;

use DI\Container;
use App\Support\Storage\Session;
use Slim\Csrf\Guard;
use Slim\Views\Twig;

abstract class Middleware
{
    protected $view;

    protected $session;
    
    protected $csrf;

    public function __construct(Container $container)
    {
        $this->view = $container->get(Twig::class);
        $this->session = $container->get(Session::class);
        $this->csrf = $container->get(Guard::class);
    }
}