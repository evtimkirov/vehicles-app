<?php

namespace App\Service;

use App\Entity\Car;
use App\Entity\Motorcycle;
use App\Entity\Truck;
use App\Entity\Trailer;
use App\Enum\CarCategory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class VehicleValidationService
{
    public function __construct(
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * Validate the vehicles by their types
     *
     * @param array $data
     * @return array
     */
    public function validate(array $data): array
    {
        $errors = [];

        if (!isset($data['type'])) {
            return ['type' => 'This field is required.'];
        }

        if (isset($data['price'])) {
            $data['price'] = (float) $data['price'];
        }
        if (isset($data['quantity'])) {
            $data['quantity'] = (int) $data['quantity'];
        }
        if (isset($data['engine_capacity'])) {
            $data['engine_capacity'] = (float) $data['engine_capacity'];
        }
        if (isset($data['doors'])) {
            $data['doors'] = (int) $data['doors'];
        }
        if (isset($data['beds'])) {
            $data['beds'] = (int) $data['beds'];
        }
        if (isset($data['axles'])) {
            $data['axles'] = (int) $data['axles'];
        }
        if (isset($data['load_capacity'])) {
            $data['load_capacity'] = (float) $data['load_capacity'];
        }

        $data['type'] = strtolower(trim($data['type']));

        // Merge common and specified properties
        $fields = [
            'brand' => [new Assert\NotBlank(), new Assert\Length(['min' => 2, 'max' => 100])],
            'model' => [new Assert\NotBlank(), new Assert\Length(['min' => 1, 'max' => 100])],
            'price' => [new Assert\NotBlank(), new Assert\Type('numeric'), new Assert\Positive()],
            'quantity' => [new Assert\NotNull(), new Assert\Type('integer'), new Assert\PositiveOrZero()],
            'type' => [new Assert\NotBlank(), new Assert\Choice(['car','motorcycle','truck','trailer'])]
        ];

        // Add the specific properties
        $typeFields = match ($data['type']) {
            'car' => [
                'engine_capacity' => [new Assert\NotBlank(), new Assert\Type('numeric')],
                'colour' => [new Assert\NotBlank(), new Assert\Length(['max' => 50])],
                'doors' => [new Assert\NotBlank(), new Assert\Type('integer')],
                'category' => [new Assert\NotBlank(), new Assert\Choice(['sedan', 'hatchback', 'suv', 'tourer'])]
            ],
            'motorcycle' => [
                'engine_capacity' => [new Assert\NotBlank(), new Assert\Type('numeric')],
                'colour' => [new Assert\NotBlank(), new Assert\Length(['max' => 50])]
            ],
            'truck' => [
                'engine_capacity' => [new Assert\NotBlank(), new Assert\Type('numeric')],
                'colour' => [new Assert\NotBlank(), new Assert\Length(['max' => 50])],
                'beds' => [new Assert\NotBlank(), new Assert\Type('integer')]
            ],
            'trailer' => [
                'load_capacity' => [new Assert\NotBlank(), new Assert\Type('numeric')],
                'axles' => [new Assert\NotBlank(), new Assert\Type('integer')]
            ],
            default => []
        };

        $fields = array_merge($fields, $typeFields);

        $constraints = new Assert\Collection([
            'fields' => $fields,
            'allowExtraFields' => true,
        ]);

        $violations = $this->validator->validate($data, $constraints);

        foreach ($violations as $violation) {
            $property = trim($violation->getPropertyPath(), '[]');
            if (!isset($errors[$property])) {
                $errors[$property] = $violation->getMessage();
            }
        }

        return $errors;
    }

    /**
     * Create vehicles
     *
     * @param array $data
     * @param $currentUser
     * @return Car|Motorcycle|Trailer|Truck
     */
    public function createEntity(array $data, $currentUser)
    {
        $data['type'] = strtolower(trim($data['type']));

        $vehicle = match ($data['type']) {
            'car' => (new Car())
                ->setEngineCapacity($data['engine_capacity'])
                ->setColour($data['colour'])
                ->setDoors($data['doors'])
                ->setCategory(CarCategory::from($data['category'])),
            'motorcycle' => (new Motorcycle())
                ->setEngineCapacity($data['engine_capacity'])
                ->setColour($data['colour']),
            'truck' => (new Truck())
                ->setEngineCapacity($data['engine_capacity'])
                ->setColour($data['colour'])
                ->setBeds($data['beds']),
            'trailer' => (new Trailer())
                ->setLoadCapacity($data['load_capacity'])
                ->setAxles($data['axles']),
            default => throw new \InvalidArgumentException("Unsupported vehicle type: " . ($data['type'] ?? 'null')),
        };

        // Common properties
        $vehicle
            ->setBrand($data['brand'])
            ->setModel($data['model'])
            ->setPrice($data['price'])
            ->setQuantity($data['quantity']);

        // Set merchant
        $vehicle->setMerchant($currentUser);

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();

        return $vehicle;
    }
}
