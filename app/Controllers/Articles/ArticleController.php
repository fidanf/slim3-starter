<?php


namespace App\Controllers\Articles;

use App\Controllers\Controller;
use App\Database\Transformers\ArticleTransformer;
use App\Models\Article;
use App\Validation\{Forms\ArticleForm, Validator};
use League\Fractal\Resource\{Collection, Item};
use Predis\Response\ResponseInterface;
use Slim\Http\{Request, Response};
use Faker\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticleController extends Controller
{
    /**
     * @apiGroup Articles
     * @apiName index
     * @api {get} /article
     * @apiSuccess (200) {String[]}     articles            List of articles.
     * @apiSuccess {Int}                article.id          Article ID.
     * @apiSuccess {String}             article.title       The article's title.
     * @apiSuccess {String}             article.body        The article's body.
     * @apiSuccess {String}             article.published   Since when the article was published/created.
     * @apiSuccess {String}             article.updated     Since when the article was updated.
     * @apiDescription Get all articles
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * "data": {
     *          "id": 1,
     *          "title": "Title 1",
     *          "body": "My first article",
     *          "published": "2 days before",
     *          "updated": "2 days before"
     *      },
     *      {
     *          "id": 1,
     *          "title": "Title 2",
     *          "body": "My second article",
     *          "published": "3 days before",
     *          "updated": "1 days before"
     *      },
     * }
     */

     /**
     * @param Response $response
     * @return Response
     */
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


    /**
     * @apiGroup Articles
     * @apiName show
     * @api {get} /article/:id
     * @apiParam {Number} id Article's unique ID.
     * @apiSuccess {Int}                article.id          Article ID.
     * @apiSuccess {String}             article.title       The article's title.
     * @apiSuccess {String}             article.body        The article's body.
     * @apiSuccess {String}             article.published   Since when the article was published/created.
     * @apiSuccess {String}             article.updated     Since when the article was updated.
     * @apiDescription Gets an article by ID.
     * @apiSampleRequest http://localhost:8000/article/:id
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * "data": {
     *      "id": 1,
     *      "title": "Title 1",
     *      "body": "My first article",
     *      "published": "2 days before",
     *      "updated": "2 days before"
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 404 Not Found
     * {
     *   "error": "Record was not found"
     * }
     */

     /**
     * @param Response $response
     * @param int $id
     * @return Response
     */
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

    /**
     * @apiGroup Articles
     * @apiName store
     * @api {post} /article
     * @apiParam {String} title The article's title.
     * @apiParam {Text} body The article's body.
     * @apiSuccess {Int}                article.id          Article ID.
     * @apiSuccess {String}             article.title       The article's title.
     * @apiSuccess {String}             article.body        The article's body.
     * @apiSuccess {String}             article.published   Since when the article was published/created.
     * @apiSuccess {String}             article.updated     Since when the article was updated.
     * @apiDescription Creates an article.
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     * "data": {
     *      "id": 1,
     *      "title": "My title",
     *      "body": "My body",
     *      "published": "2 seconds before",
     *      "updated": "2 seconds before"
     * }
     * @param Request $request
     * @param Response $response
     * @param Validator $validator
     * @return Response
     */
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

    /**
    * @apiGroup Articles
    * @apiName delete
    * @api {delete} /article/:id
    * @apiParam {Number} id The article's unique ID.
    * @apiDescription Deletes an article.
    * @apiSuccessExample {json} Success-Response:
    * HTTP/1.1 204 OK
    * @apiErrorExample {json} Error-Response:
    * HTTP/1.1 404 Not Found
    * {
    *   "error": "No query results for model [App\\Models\\Article] :id"
    * }
    */

    /**
     * @param Response $response
     * @param int $id
     * @return Response
     */
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

    public function seed(Response $response, Factory $faker, int $count): Response
    {
        $factory = $faker::create();
        $articles = [];
        for($i = 0; $i < $count; $i++ ) {
            $articles[] = Article::create([
                'title' => $factory->realText($factory->numberBetween(10, 50)),
                'body' => $factory->text(500),
            ]);
        }
        return $response->withJson($articles, 200);
    }
}