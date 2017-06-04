<?php

namespace App\Controllers;

use App\Database\EloquentDatabase;
use App\Database\PDODatabase;
use Interop\Container\ContainerInterface as Container;
use Slim\Views\Twig;

abstract class Controller
{
    protected $view;
    protected $db;

    /**
     * Controller constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->view = $container->get(Twig::class);
        $this->db = $container->get(EloquentDatabase::class);
    }

}