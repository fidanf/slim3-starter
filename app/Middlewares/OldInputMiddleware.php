<?php

namespace App\Middlewares;

use Slim\Http\{Request, Response};

class OldInputMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next)
    {
        $this->view->getEnvironment()->addGlobal('old', $this->session->get('old'));
        $this->session->set('old', $request->getParams());

        $response = $next($request, $response);
        return $response;
    }
}