<?php 

namespace App\Controllers\Web;

use App\Controllers\Controller;
use App\Events\Handlers\CreateUserRecord;
use App\Events\Handlers\EmailConfirmedRegistration;
use App\Events\UserRegisterEvent;
use App\Models\User;
use App\Validation\{Forms\LoginForm, Validator};
use Psr\Http\Message\ResponseInterface;
use Slim\Http\{Response, Request};

class HomeController extends Controller {

	public function index(Request $request, Response $response, Validator $validator): ResponseInterface
	{
	    if($request->isPost()) {
            $validator->validate($request, LoginForm::getRules());
            
            if($validator->fails()) {
                $this->flash->addMessage('error', 'Errors while creating the user.');
                return $response->withRedirect($this->router->pathFor('home'));
            }

            $user = new User;
            $user->username = $request->getParam('username');
            $user->email = $request->getParam('email');
            $user->password = password_hash($request->getParam('password'), PASSWORD_BCRYPT);

            $event = new UserRegisterEvent($user, $this->mail);
            $event->attach(new CreateUserRecord);
            $event->attach(new EmailConfirmedRegistration);
            $event->notify();

            $this->flash->addMessage('success', 'User was created!');
            return $response->withRedirect($this->router->pathFor('home'));
        }

        return $this->view->render($response,'templates/index.twig');
	}



}