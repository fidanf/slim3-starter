<?php

namespace App\Models;

use App\Database\Observers\ArticleObserver;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = ['title', 'body'];
    protected $dates = ['created_at', 'updated_at'];

}