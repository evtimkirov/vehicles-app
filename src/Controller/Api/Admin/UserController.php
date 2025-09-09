<?php

namespace App\Controller\Api\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    /**
     * Get the followed vehicles
     *
     * @param EntityManagerInterface $entityManager
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/api/v1/users/{id}/vehicles', methods: ['GET'])]
    public function getUserVehicles(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(
                [
                    'status' => 'error',
                    'message' => 'User not found',
                ],
                404
            );
        }

        return $this->json([
            'status' => 'success',
            'user_id' => $id,
            'vehicles' => $user->getFollowedVehicles(),
        ]);
    }
}
