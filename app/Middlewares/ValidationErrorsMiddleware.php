<?php

namespace App\Middlewares;

use Slim\Views\Twig;
use Slim\Http\{Request, Response};

class ValidationErrorsMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $view = $this->container->get(Twig::class);

        if(isset($_SESSION['errors'])){
            $view->getEnvironment()->addGlobal('errors', $_SESSION['errors']);
            unset($_SESSION['errors']);
        }

        $response = $next($request, $response);
        return $response;
    }
}