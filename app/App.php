<?php 

namespace App;

use DI\ContainerBuilder;
use Interop\Container\ContainerInterface as Container;

use Slim\Flash\Messages;
use Slim\Views\{Twig, TwigExtension};
use Slim\Http\{Request, Response};
use App\Support\{NotFound, Storage\SessionStorage, Extensions\VarDump};
use App\Database\Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;
use Faker\Factory;
use Slim\Csrf\Guard;
use Twig_Extension_Debug;
use App\Validation\Validator;


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
                $view->getEnvironment()->addGlobal('flash', $container->get(Messages::class));
                return $view;
            },

            Eloquent::class => function () use ($config)  {
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

            Messages::class => function() {
                return new Messages;
            },

            SessionStorage::class => function() {
                return new SessionStorage;
            },

            Validator::class => function(Container $container) {
                return new Validator($container->get(SessionStorage::class));
            },

            'notFoundHandler' => function(Container $container){
                return new NotFound($container->get(Twig::class));
            },

        ];

        $builder->addDefinitions($config['settings']);
        $builder->addDefinitions($dependencies);
    }
}