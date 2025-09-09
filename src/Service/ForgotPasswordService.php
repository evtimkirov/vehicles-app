<?php

namespace App\Service;

use App\Validator\ExistingEmail;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ForgotPasswordService
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    /**
     * User data validation
     *
     * @param array $data
     * @return array
     */
    public function validate(array $data): array
    {
        $constraints = new Assert\Collection([
            'email' => [new Assert\NotBlank(), new Assert\Email(), new ExistingEmail()],
        ]);

        $violations = $this->validator->validate($data, $constraints);

        $errors = [];
        foreach ($violations as $violation) {
            $property = $violation->getPropertyPath();
            $property = trim($property, '[]');

            if (!isset($errors[$property])) {
                $errors[$property] = $violation->getMessage();
            }
        }

        return $errors;
    }
}
