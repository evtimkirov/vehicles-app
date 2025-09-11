<?php

namespace App\Controller\Api;

use App\Service\RegistrationService;
use App\Service\UserValidationService;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route('/api/v1/registration', name: 'api_registration', methods: ['POST'])]
final class RegistrationController extends AbstractController
{
    public function __invoke(
        Request $request,
        UserValidationService $validatorService,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $manager,
        RegistrationService $registrationService
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        // Validations
        $errors = $validatorService->validate($data);
        if (!empty($errors)) {
            return new JsonResponse(['status' => 'error', 'errors' => $errors], 422);
        }

        // Role
        $role = $manager->getRepository(Role::class)->findOneBy(['name' => 'role_buyer']);
        if (!$role) {
            return new JsonResponse(['status' => 'error', 'errors' => ['role' => ['Invalid role']]], 400);
        }

        // Create a new user
        $user = $registrationService->registerUser($data, $role);

        return new JsonResponse([
            'status'  => 'success',
            'message' => 'The user has been created successfully.',
            'data'    => [
                'email'      => $user->getEmail(),
                'first_name' => $user->getFirstName(),
                'last_name'  => $user->getLastName(),
                'role'       => $role->getName() === 'role_merchant' ? 'merchant' : 'buyer',
            ],
        ], 201);
    }
}
