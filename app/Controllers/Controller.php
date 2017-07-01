<?php

namespace App\Controllers;

use Interop\Container\ContainerInterface as Container;
use App\Database\Eloquent;
use App\Support\Storage\SessionStorage;
use Slim\Flash\Messages;
use Slim\Views\Twig;

abstract class Controller
{
    protected $view;
    protected $db;
    protected $session;
    protected $flash;
    protected $mail;
    protected $router;

    /**
     * Controller constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->view = $container->get(Twig::class);
        $this->db = $container->get(Eloquent::class);
        $this->session = $container->get(SessionStorage::class);
        $this->flash = $container->get(Messages::class);
        $this->mail = $container->get('mail');
        $this->router = $container->get('router');
        $this->fractal = $container->get('fractal');
    }

}