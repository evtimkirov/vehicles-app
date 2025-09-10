<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class UniqueEmail extends Constraint
{
    public string $message = 'The email {{ value }} is already registered.';

    public function validatedBy(): string
    {
        return UniqueEmailValidator::class;
    }
}
