<?php

namespace App\Controller\Api\Admin;

use App\Entity\Vehicle;
use App\Service\VehicleSerializer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class VehicleController extends AbstractController
{
    #[Route('/api/v1/vehicles', name: 'vehicles', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, VehicleSerializer $vehicleSerializer): JsonResponse
    {
        $vehicles = $entityManager->getRepository(Vehicle::class)->findBy([], ['id' => 'DESC']);

        return new JsonResponse([
            'status' => 'success',
            'data'   => $vehicleSerializer->serializeCollection($vehicles),
        ]);
    }
}
