<?php


namespace App\Validation\Forms;

use App\Validation\Contracts\FormInterface;
use Respect\Validation\Validator as V;

class LoginForm implements FormInterface
{

    public static function getRules(): array
    {
        return [
            'name' => v::alpha(' '),
            'email' => V::notEmpty()->email(),
            'password' => V::notEmpty()->alnum()->noWhiteSpace()
        ];
    }
}