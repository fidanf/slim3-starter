<?php

namespace App\Middlewares;

use Slim\Views\Twig;
use Slim\Http\{Request, Response};

class OldInputMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $view = $this->container->get(Twig::class);

        if (!isset($_SESSION['old'])) {
            $_SESSION['old'] = null;
        }

        $view->getEnvironment()->addGlobal('old', $_SESSION['old']);
        $_SESSION['old'] = $request->getParams();

        $response = $next($request, $response);

        return $response;
    }
}