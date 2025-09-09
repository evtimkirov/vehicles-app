<?php

namespace App\Controller\Api\Admin;

use App\Entity\Vehicle;
use App\Service\VehicleSerializer;
use App\Service\VehicleValidationService;
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


    /**
     * Store new vehicle
     *
     * @param Request $request
     * @param VehicleValidationService $service
     * @return JsonResponse
     */
    #[Route('/api/v1/vehicles', methods: ['POST'])]
    public function store(Request $request, VehicleValidationService $service): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $errors = $service->validate($data);
        if (!empty($errors)) {
            return $this->json([
                'status' => 'error',
                'errors' => $errors
            ], 422);
        }

        $vehicle = $service->createEntity($data, $this->getUser());

        return $this->json([
            'status'  => 'success',
            'message' => 'Vehicle created',
            'data' => [
                'id'    => $vehicle->getId(),
                'brand' => $vehicle->getBrand(),
                'model' => $vehicle->getModel(),
                'type'  => $data['type']
            ]
        ], 201);
    }
}
