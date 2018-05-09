<?php 

namespace App\Controllers\Web\Articles;

use App\Controllers\Controller;
use App\Models\Article;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\{Response, Request};

class ArticleController extends Controller {

    public function list(Request $request, Response $response): ResponseInterface
    {
        $perPage = $request->getParam('perPage') ?? 5;
        $articles = Article::paginate($perPage)->appends($request->getParams());
        return $this->view->render($response, 'templates/articles/article.index.twig', compact('articles'));
    }
    public function show(Response $response, int $id)
    {
        $article = Article::find($id);
        return $this->view->render($response, 'templates/articles/article.show.twig', compact('article'));
    }
}