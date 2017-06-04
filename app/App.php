<?php 

namespace App;

use App\Support\Storage\SessionStorage;
use App\Validation\Validator;
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
                $view->getEnvironment()->addGlobal('APP_NAME', getenv('APP_NAME'));
                return $view;
            },

            EloquentDatabase::class => function () use ($config)  {
                 $capsule = new Capsule;
                 $capsule->addConnection($config['db']);
                 $capsule->bootEloquent();
                 return $capsule;
             },

            Factory::class => function () {
                 return new Factory();
            },

            Guard::class => function() {
                $guard = new Guard;
                $guard->setFailureCallable(function (Request $request, Response $response, callable $next) {
                    $request = $request->withAttribute('csrf_status', false);
                    return $next($request, $response);
                });
                return $guard;
            },

            SessionStorage::class => function() {
                return new SessionStorage;
            },

            Validator::class => function(Container $container) {
                return new Validator($container->get(SessionStorage::class)); // ->with(App\\Validation\\Rules);
            },

            'notFoundHandler' => function(Container $container){
                return new NotFound($container->get(Twig::class));
            },

        ];

        $builder->addDefinitions($config['settings']);
        $builder->addDefinitions($dependencies);
    }
}