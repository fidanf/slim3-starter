<?php


namespace App\Controllers\Articles;

use App\Controllers\Controller;
use App\Database\Transformers\ArticleTransformer;
use App\Models\Article;
use App\Validation\{Forms\ArticleForm, Validator};
use League\Fractal\Resource\{Collection, Item};
use Slim\Http\{Request, Response};

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

    public function store(Request $request, Response $response, Validator $validator)
    {
        $validator->validate($request,ArticleForm::getRules());
        if($validator->fails()) {
            return $response->withJson(['errors' => $this->session->get('errors')], 400);
        }
        $article = Article::create($request->getParams());
        return $response->withJson($article, 200);
    }

    public function delete(Request $request, Response $response): Response
    {
        die('Delete');
    }
}