<?php


namespace App\Database\Transformers;

use App\Models\Article;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;


class ArticleTransformer extends TransformerAbstract
{
    public function transform(Article $article)
    {
        return [
            'id' => $article->id,
            'title' => $article->title,
            'body' => $article->body,
            'published' => $article->created_at->diffForHumans(Carbon::now()),
            'updated' => $article->updated_at->diffForHumans(Carbon::now()),
        ];
    }
}