<?php 

namespace App\Controllers;

use DI\Container;
use Slim\Http\{Response, Request};

class HomeController extends Controller {

	public function index(Request $request, Response $response, Container $container)
	{
	    if($request->getMethod() == 'POST') {
	        return $response->write('Success!')->withStatus(200);
        }
        return $this->view->render($response,'templates/index.twig');
	}
}