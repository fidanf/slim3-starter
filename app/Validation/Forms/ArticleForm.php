<?php


namespace App\Validation\Forms;

use App\Validation\Contracts\FormInterface;
use Respect\Validation\Validator as V;

class ArticleForm implements FormInterface
{

    public static function getRules(): array
    {
        return [
            'title' => V::length(6,30)->notEmpty(),
            'body' => V::notEmpty(),
        ];
    }
}