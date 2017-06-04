<?php

namespace App\Middlewares;

use Slim\Http\{Request, Response};

class ValidationErrorsMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $errors = $this->session->get('errors');
        if($errors) {
            $this->view->getEnvironment()->addGlobal('errors', $errors);
            $this->session->unset('errors');
        }

        $response = $next($request, $response);
        return $response;
    }
}