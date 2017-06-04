<?php


namespace App\Support;

use Slim\Handlers\AbstractHandler;
use Slim\Http\{Request, Response};
use Slim\Views\Twig;

class NotFound extends AbstractHandler
{
    protected $view;
    protected $output;

    public function __construct(Twig $view)
    {
        $this->view = $view;
    }

    public function __invoke(Request $request, Response $response)
    {
        $contentType = $this->determineContentType($request);
        switch ($contentType){
            case 'application/json':
                $this->output = $this->renderNotFoundJSON($response);
                break;
            case 'text/html':
                $this->output = $this->renderNotFoundHTML($response);
                error_log('404 Not Found');
                break;
        }

        return $this->output->withStatus(404);
    }

    protected function renderNotFoundJSON(Response $response)
    {
        return $response->withJson([
            'error' => 'Not found'
        ]);
    }

    protected function renderNotFoundHTML(Response $response)
    {
        return $this->view->render($response, '/errors/404.twig');
    }
}