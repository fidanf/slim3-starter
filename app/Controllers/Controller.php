<?php

namespace App\Controllers;

use Interop\Container\ContainerInterface as Container;
use App\Support\Storage\Session;
use League\Fractal\Manager;
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
    protected $cache;

    /**
     * Controller constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->view = $container->get(Twig::class);
        $this->session = $container->get(Session::class);
        $this->flash = $container->get(Messages::class);
        $this->fractal = $container->get(Manager::class);
        $this->db = $container->get('database');
        $this->mail = $container->get('mail');
        $this->router = $container->get('router');
        $this->cache = $container->get('cache');
    }

}