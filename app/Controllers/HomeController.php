<?php 

namespace App\Controllers;

use App\Models\User;
use App\Validation\Forms\LoginForm;
use App\Validation\Validator;
use Slim\Http\{Response, Request};

class HomeController extends Controller {

	public function index(Request $request, Response $response, Validator $validator)
	{
	    if($request->getMethod() == 'POST') {
            $validator->validate($request, LoginForm::getRules());
            if($validator->fails()){
                $this->flash->addMessage('error', 'Errors while creating the user.');
                return $response->withRedirect($this->router->pathFor('home'));
            }
            User::create([
                'name' => $request->getParam('name'),
                'email' => $request->getParam('email'),
                'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT)
            ]);

            $this->flash->addMessage('success', 'User was created!');
            return $response->withRedirect($this->router->pathFor('home'));

        }
        return $this->view->render($response,'templates/index.twig');
	}
}