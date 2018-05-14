<?php


namespace App\Database;

use Illuminate\Database\Capsule\Manager;

class Eloquent extends Manager implements DatabaseInterface
{

    public function bootEloquent()
    {
        parent::bootEloquent();
        $this->registerObservers();
    }

    protected function registerObservers()
    {
        \App\Models\Article::observe(new \App\Database\Observers\ArticleObserver());
    }

}