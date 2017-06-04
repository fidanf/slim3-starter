<?php

namespace App\Validation;

use App\Support\Storage\SessionStorage;
use App\Validation\Contracts\ValidatorInterface;
use Respect\Validation\Exceptions\NestedValidationException;
use Slim\Http\Request;

class Validator implements ValidatorInterface
{
    protected $session;
    protected $errors = [];

    public function __construct(SessionStorage $session)
    {
        $this->session = $session;
    }

    public function validate(Request $request, array $rules): ValidatorInterface
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        $this->session->set('errors', $this->errors);

        return $this;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }
}