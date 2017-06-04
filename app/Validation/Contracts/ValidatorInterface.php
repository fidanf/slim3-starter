<?php

namespace App\Validation\Contracts;

use Slim\Http\Request;

interface ValidatorInterface
{
    public function validate(Request $request, array $rules): ValidatorInterface;
    public function fails(): bool;
}