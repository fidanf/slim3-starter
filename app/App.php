<?php 

namespace App;

use DI\ContainerBuilder;
use Interop\Container\ContainerInterface as Container;

use Faker\Factory;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Database\{PDODatabase, EloquentDatabase};
use Slim\Csrf\Guard;
use Slim\Handlers\NotFound;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\{Twig, TwigExtension};
use Twig_Extension_Debug;
use App\Support\Extensions\VarDump;


class App extends \DI\Bridge\Slim\App
{

    protected function configureContainer(ContainerBuilder $builder)
    {

        $config = require_once __DIR__ . '/Settings.php';

        $dependencies = [
            Twig::class => function (Container $container) use ($config) {
                $view = new Twig('../resources/views', $config['twig_config']);
                $view->addExtension(new TwigExtension(
                    $container->get('router'),
                    $container->get('request')->getUri()
                ));
                $view->addExtension(new Twig_Extension_Debug());
                $view->addExtension(new VarDump());
                return $view;
            }, // Intégration de Twig

             PDODatabase::class => function () {
                 return new \PDO(
                     "{$_ENV['DB_DRIVER']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
                     "{$_ENV['DB_USER']}",
                     "{$_ENV['DB_PASSWORD']}", [
                     \PDO::ERRMODE_EXCEPTION,
                     \PDO::ATTR_ERRMODE,
                     \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                 ]);
             }, // Intégration de PDO

            EloquentDatabase::class => function () use ($config)  {
                 $capsule = new Capsule;
                 $capsule->addConnection($config['db']);
                 $capsule->bootEloquent();
                 return $capsule;
             }, // Intégration d'Eloquent

            'notFoundHandler' => function(Container $container){
                return new NotFound($container->get(Twig::class));
            }, // Intégration et surcharge du notFoundHandler de Slim

            Factory::class => function () {
                 return new Factory();
            }, // Intégration de Faker

            Guard::class => function() {
                $guard = new Guard;
                $guard->setFailureCallable(function (Request $request, Response $response, callable $next) {
                    $request = $request->withAttribute('csrf_status', false);
                    return $next($request, $response);
                });
                return $guard;
            },

        ];

        $builder->addDefinitions($config['settings']);
        $builder->addDefinitions($dependencies);
    }
}