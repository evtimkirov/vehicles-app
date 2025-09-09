<?php

namespace App\Controller\Api;

use App\Service\UserValidationService;
use App\Entity\User;
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
        EntityManagerInterface $manager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $errors = $validatorService->validate($data);
        if (!empty($errors)) {
            return new JsonResponse(['status' => 'error', 'errors' => $errors], 422);
        }

        $role = $manager->getRepository(Role::class)->findOneBy(['name' => $data['role']]);
        if (!$role) {
            return new JsonResponse(['status' => 'error', 'errors' => ['role' => ['Invalid role']]], 400);
        }

        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['password']));
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setRole($role);

        $manager->persist($user);
        $manager->flush();

        return new JsonResponse([
            'status' => 'success',
            'message' => 'The user has been created successfully.',
            'data' => [
                'email' => $user->getEmail(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'role' => $role->getName() === 'role_merchant' ? 'merchant' : 'buyer',
            ],
        ], 201);
    }
}
