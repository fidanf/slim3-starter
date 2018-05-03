<?php

namespace App\Middlewares;

use Slim\Http\{Request, Response};

class CsrfMiddleware extends Middleware
{

    public function __invoke(Request $request, Response $response, callable $next)
    {

        $this->view->getEnvironment()->addGlobal('csrf', [
          'field' => '
            <input type="hidden" name="' . $this->csrf->getTokenNameKey() . '" value="' . $this->csrf->getTokenName() . '">
            <input type="hidden" name="' . $this->csrf->getTokenValueKey() . '" value="' . $this->csrf->getTokenValue() . '">
           ',
        ]);

        if($request->getAttribute('csrf_status') === false) {
            return $this->view->render($response->withStatus(403), '/errors/403.twig');
        }

        $response = $next($request, $response);
        return $response;

    }

}