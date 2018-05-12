<?php 

namespace App;

use App\Support\Email\Mailer;
use App\Support\{NotFound, Storage\Cache, Storage\Session, Extensions\VarDump};
use App\Validation\Validator;
use Cocur\Slugify\Slugify;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Interop\Container\ContainerInterface as Container;
use Monolog\{Handler\FingersCrossedHandler, Handler\StreamHandler, Logger};
use Noodlehaus\Config;
use Predis\Client;
use Slim\Csrf\Guard;
use Slim\Flash\Messages;
use Slim\Http\{Request, Response};
use Slim\Views\{Twig, TwigExtension};
use Swift_Mailer;
use Swift_SmtpTransport;
use Twig_Extension_Debug;

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

            Config::class => function() {
                return new Config(base_path('app/Config.php'));
            },
            
            Twig::class => function(Container $c, Config $config) {
                $view = new Twig([
                    base_path('resources/views'),
                    base_path('resources/assets')
                ], $config->get('twig'));

                $view->addExtension(new TwigExtension(
                    $c->get('router'),
                    $c->get('request')->getUri()
                ));

                $view->addExtension(new Twig_Extension_Debug());
                $view->addExtension(new VarDump());
                $view->getEnvironment()->addGlobal('APP_NAME', getenv('APP_NAME'));
                $view->getEnvironment()->addGlobal('flash', $c->get(Messages::class));

                return $view;
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

            Validator::class => function(Container $c) {
                return new Validator($c->get(Session::class));
            },

            Logger::class => function() {
                $logger = new Logger('logger');
                $filename = base_path('storage/logs/error.log');
                $stream = new StreamHandler($filename, Logger::DEBUG);
                $fingersCrossed = new FingersCrossedHandler($stream, Logger::ERROR);
                $logger->pushHandler($fingersCrossed);

                return $logger;
            },

            'database' => function(Config $config)  {
                $capsule = new Capsule;
                $capsule->setEventDispatcher(new Dispatcher);
                $capsule->addConnection($config->get('db'));
                $capsule->setAsGlobal();
                $capsule->bootEloquent();
                
                return $capsule;
             },

            'notFoundHandler' => function(Container $c){
                return new NotFound($c->get(Twig::class));
            },

            'errorHandler' => function(Container $c) {
                return new Support\Error(
                    $c->get('settings.displayErrorDetails'),
                    $c->get(Logger::class)
                );
            },

            'mail' => function(Container $container, Config $config) {
                $transport = (Swift_SmtpTransport::newInstance(
                    $config->get('swiftmailer.host'), 
                    $config->get('swiftmailer.port')
                ))
                ->setUsername($config->get('swiftmailer.username'))
                ->setPassword($config->get('swiftmailer.password'));

                $swift = Swift_Mailer::newInstance($transport);

                return (new Mailer($swift, $container->get(Twig::class)))
                    ->alwaysFrom(
                        $config->get('swiftmailer.from.address'),
                        $config->get('swiftmailer.from.name')
                    );
            },

            'cache' => function(Config $config) {
                $client = new Client([
                    'scheme' => 'tcp',
                    'host' => $config->get('redis.host'),
                    'port' => $config->get('redis.port'),
                    'password' => $config->get('redis.password'),
                ]);

                return new Cache($client);
            },


        ];

        $builder->addDefinitions($this->definitions);
        $builder->addDefinitions($dependencies);
    }
}