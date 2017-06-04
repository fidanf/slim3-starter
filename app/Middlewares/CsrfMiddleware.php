<?php


namespace App\Middlewares;

use Slim\Csrf\Guard;
use Slim\Views\Twig;
use Slim\Http\{Request, Response};

class CsrfMiddleware extends Middleware
{

    public function __invoke(Request $request, Response $response, callable $next)
    {
        $csrf = $this->container->get(Guard::class);
        $view = $this->container->get(Twig::class);

        $view->getEnvironment()->addGlobal('csrf', [
            'field' => '
           <input type="hidden" name="' . $csrf->getTokenNameKey() . '" value="' . $csrf->getTokenName() . '">
           <input type="hidden" name="' . $csrf->getTokenValueKey() . '" value="' . $csrf->getTokenValue() . '">
           ',
        ]);

        if($request->getAttribute('csrf_status') === false) {
            return $view->render($response->withStatus(403), '/errors/403.twig');
        }

        $response = $next($request, $response);
        return $response;

    }

}