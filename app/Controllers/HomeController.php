<?php 

namespace App\Controllers;

use App\Models\User;
use App\Validation\{Forms\LoginForm, Validator};
use Slim\Http\{Response, Request};
use App\Support\Email\Templates\Welcome;
use Swift_SwiftException;

class HomeController extends Controller {

	public function index(Request $request, Response $response, Validator $validator)
	{

	    if($request->getMethod() == 'POST') {
            $validator->validate($request, LoginForm::getRules());
            
            if($validator->fails()) {
                $this->flash->addMessage('error', 'Errors while creating the user.');
                return $response->withRedirect($this->router->pathFor('home'));
            }
            
            $user = new User;
            $user->name = $request->getParam('name');
            $user->email = $request->getParam('email');

            try {
                $this->mail->to($user->email, $user->name)->send(new Welcome($user));
                return $response->write('Mail send!')->withStatus(200);
            } catch (Swift_SwiftException $e) {
                debug($e);
            }

            // User::create([
            //     'name' => $request->getParam('name'),
            //     'email' => $request->getParam('email'),
            //     'password' => password_hash($request->getParam('password'), PASSWORD_BCRYPT)
            // ]);

            // $this->flash->addMessage('success', 'User was created!');
            // return $response->withRedirect($this->router->pathFor('home'));
        }
        
        return $this->view->render($response,'templates/index.twig');
	}
}