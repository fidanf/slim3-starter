<?php

namespace App\Controllers\Api\Articles;

use App\Controllers\Controller;
use App\Database\Transformers\ArticleTransformer;
use App\Models\Article;
use App\Validation\{Forms\ArticleForm, Validator};
use Illuminate\Database\Eloquent\ModelNotFoundException;
use League\Fractal\Resource\{Collection, Item};
use Slim\Http\{Request, Response};

class ArticleController extends Controller
{
    
    public function index(Response $response): Response
    {
        // No caching
        /*
        $articles = Article::all();
        $resource = new Collection($articles, new ArticleTransformer);
        $data = $this->fractal->createData($resource)->toArray();
        return $response->withJson($data, 200);
        */

        // Caching for 10 minutes
        $result =  $this->cache->remember('articles', 10, function() use ($response) {
            $articles = Article::all();
            $resource = new Collection($articles, new ArticleTransformer);
            return $this->fractal->createData($resource)->toJson();
        });
        return $response->withHeader('Content-Type','application/json')->withStatus(200)->write($result);
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

    public function store(Request $request, Response $response, Validator $validator): Response
    {
        $validator->validate($request,ArticleForm::getRules());
        if($validator->fails()) {
            return $response->withJson(['errors' => $this->session->get('errors')], 400);
        }
        $article = Article::create($request->getParams());
        return $response->withJson($article, 200);
    }

    public function update(Request $request, Response $response, Validator $validator, int $id): Response
    {
        $article = Article::find($id);
        if(!$article) {
            return $response->withJson(['error' => 'Record was not found'], 404);
        }

        $validator->validate($request,ArticleForm::getRules());
        if($validator->fails()) {
            return $response->withJson(['errors' => $this->session->get('errors')], 400);
        }

        $article->fill($request->getParams())->save();
        return $response->withJson($article, 200);
    }

    public function delete(Response $response, int $id): Response
    {
        try {
            $article = Article::findOrfail($id);
            $article->delete();
            return $response->withStatus(204);
        } catch (ModelNotFoundException $e) {
            return $response->withJson(['error' => $e->getMessage()], 404);
        } 
    }


}