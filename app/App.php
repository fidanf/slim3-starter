<?php 

namespace App;

use DI\ContainerBuilder;
use Interop\Container\ContainerInterface as Container;

use League\Fractal\Manager;
use Predis\Client;
use Slim\Flash\Messages;
use Monolog\{Handler\FingersCrossedHandler, Handler\StreamHandler, Logger};
use App\Support\{NotFound, Storage\Cache, Storage\Session, Extensions\VarDump};
use Slim\Interfaces\RouterInterface;
use Slim\Views\{Twig, TwigExtension};
use Slim\Http\{Request, Response};
use App\Database\Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;
use Slim\Csrf\Guard;
use App\Validation\Validator;
use App\Support\Email\Mailer;
use Twig_Extension_Debug;
use Swift_SmtpTransport;
use Swift_Mailer;


class App extends \DI\Bridge\Slim\App
{

    private $definitions;

    /**
     * App constructor.
     * @param $definitions
     */
    public function __construct(array $definitions = null)
    {
        $this->definitions = $definitions;
        parent::__construct();
    }

    protected function configureContainer(ContainerBuilder $builder): void
    {
        $dependencies = [
            Twig::class => function (Container $container) {
                $view = new Twig(['../resources/views', '../resources/assets'], $container->get('twig'));
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

            Eloquent::class => function (Container $container)  {
                 $capsule = new Capsule;
                 $capsule->addConnection($container->get('db'));
                 $capsule->setAsGlobal();
                 $capsule->bootEloquent();
                 return $capsule;
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

            Validator::class => function(Container $container) {
                return new Validator($container->get(Session::class));
            },

            Logger::class => function() {
                $logger = new Logger('logger');
                $filename = __DIR__ . '/../logs/error.log';
                $stream = new StreamHandler($filename, Logger::DEBUG);
                $fingersCrossed = new FingersCrossedHandler(
                    $stream, Logger::ERROR);
                $logger->pushHandler($fingersCrossed);
                return $logger;
            },

            'notFoundHandler' => function(Container $container){
                return new NotFound($container->get(Twig::class));
            },

            'errorHandler' => function(Container $container) {
                return new Support\Error($container->get('settings.displayErrorDetails'),$container->get(Logger::class));
            },

            'mail' => function (Container $container) {
                $transport = (Swift_SmtpTransport::newInstance($container->get('swiftmailer')['host'], $container->get('swiftmailer')['port']))
                    ->setUsername($container->get('swiftmailer')['username'])
                    ->setPassword($container->get('swiftmailer')['password']);

                $swift = Swift_Mailer::newInstance($transport);

                return (new Mailer($swift, $container->get(Twig::class)))
                    ->alwaysFrom($container->get('swiftmailer')['from']['address'], $container->get('swiftmailer')['from']['name']);
            },

//            'fractal' => function () {*
//                return new Manager();
//            },

            'cache' => function (Container $container) {
                $client = new Client([
                    'scheme' => 'tcp',
                    'host' => $container->get('redis')['host'],
                    'port' => $container->get('redis')['port'],
                    'password' => $container->get('redis')['password'],
                ]);

                return new Cache($client);
            },


        ];

        $builder->addDefinitions($this->definitions);
//        $builder->addDefinitions(__DIR__ . '/Config.php');
        $builder->addDefinitions($dependencies);
    }
}