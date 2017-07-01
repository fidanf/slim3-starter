<?php


namespace App\Controllers\Articles;

use App\Controllers\Controller;
use App\Database\Transformers\ArticleTransformer;
use App\Models\Article;
use League\Fractal\Resource\{Collection, Item};
use Slim\Http\Response;

class ArticleController extends Controller
{
    public function index(Response $response): Response
    {
        $articles = Article::all();
        $resource = new Collection($articles, new ArticleTransformer);
        $data = $this->fractal->createData($resource)->toArray();
        return $response->withJson($data, 200);
    }

    public function show(Response $response, int $id): Response
    {
        $article = Article::find($id);
        if(!$article) {
            return $response->withJson(['error' => 'Record was not found'], 404);
        }

        $resource = new Item($article, new ArticleTransformer);
        $data = $this->fractal->createData($resource)->toArray();
        return $response->withJson($data, 200);
    }
}