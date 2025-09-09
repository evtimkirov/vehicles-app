<?php

namespace App\Validator;

use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ExistingEmailValidator extends ConstraintValidator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $value
     */
    public function validate($value, Constraint $constraint): void
    {
        /* @var ExistingEmail $constraint */
        if (null === $value || '' === $value) {
            return;
        }

        $user = $this->userRepository->findOneBy(['email' => $value]);

        if (!$user) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
