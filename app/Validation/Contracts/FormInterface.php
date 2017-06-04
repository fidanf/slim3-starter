<?php

namespace App\Validation\Contracts;

interface FormInterface
{
    public static function getRules(): array;
}