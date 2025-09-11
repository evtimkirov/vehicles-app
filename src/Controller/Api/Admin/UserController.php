<?php

namespace App\Controller\Api\Admin;

use App\Entity\User;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    /**
     * List with the followed vehicles by logged-in user
     *
     * @return JsonResponse
     */
    public function listFollowed(): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $vehicles = $user->getFollowedVehicles()->map(fn (Vehicle $v) => [
            'id' => $v->getId(),
            'brand' => $v->getBrand(),
            'model' => $v->getModel(),
            'price' => $v->getPrice(),
        ])->toArray();

        return $this->json([
            'status' => 'success',
            'data' => $vehicles,
        ]);
    }

    /**
     * Follow a vehicle
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function follow(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $data = json_decode($request->getContent(), true);
        $vehicleId = $data['id'] ?? null;

        if (!$vehicleId) {
            return $this->json(['status' => 'error', 'message' => 'vehicleId is required'], 400);
        }

        $vehicle = $entityManager->getRepository(Vehicle::class)->find($vehicleId);
        if (!$vehicle) {
            return $this->json(['status' => 'error', 'message' => 'Vehicle not found'], 404);
        }

        $user->addFollowedVehicle($vehicle);
        $entityManager->flush();

        return $this->json([
            'status' => 'success',
            'message' => 'Vehicle followed',
            'data' => [
                'user_id' => $user->getId(),
                'vehicle_id' => $vehicleId,
            ]
        ]);
    }

    /**
     * Unfollow a vehicle
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function unfollow(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        if (!$user) {
            return $this->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $data = json_decode($request->getContent(), true);
        $vehicleId = $data['id'] ?? null;

        if (!$vehicleId) {
            return $this->json(['status' => 'error', 'message' => 'vehicleId is required'], 400);
        }

        $vehicle = $entityManager->getRepository(Vehicle::class)->find($vehicleId);
        if (!$vehicle) {
            return $this->json(['status' => 'error', 'message' => 'Vehicle not found'], 404);
        }

        $user->removeFollowedVehicle($vehicle);
        $entityManager->flush();

        return $this->json([
            'status' => 'success',
            'message' => 'Vehicle unfollowed',
            'data' => [
                'user_id' => $user->getId(),
                'vehicle_id' => $vehicleId,
            ]
        ]);
    }

    /**
     * Get current user role
     *
     * @param Security $security
     * @return JsonResponse
     */
    public function getRole(Security $security): JsonResponse
    {
        $user = $security->getUser();
        if (!$user) return $this->json(['message' => 'Unauthorized'], 401);

        return $this->json(['role' => $user->getRoles()[0]]);
    }
}
