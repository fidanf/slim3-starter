<?php

namespace App\Database\Observers;

use App\Models\Article;
use Cocur\Slugify\Slugify;

class ArticleObserver
{
    public function creating(Article $article)
    {
        $article->slug = (new Slugify)->slugify($article->title);
    }
}