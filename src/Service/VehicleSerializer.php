<?php

namespace App\Service;

use App\Entity\Car;
use App\Entity\Motorcycle;
use App\Entity\Trailer;
use App\Entity\Truck;
use App\Entity\Vehicle;

/**
 * Prepare the data when get all the vehicle data.
 */
class VehicleSerializer
{
    /**
     * Returns all the available properties
     *
     * @param Vehicle $v
     * @return array
     */
    public function serialize(Vehicle $v): array
    {
        return [
            'id' => $v->getId(),
            'name' => $v->getBrand(),
            'model' => $v->getModel(),
            'price' => $v->getPrice(),
            'quantity' => $v->getQuantity(),
            'engine_capacity' => $v instanceof Car || $v instanceof Motorcycle || $v instanceof Truck ? $v->getEngineCapacity() : null,
            'colour' => $v instanceof Car || $v instanceof Motorcycle || $v instanceof Truck ? $v->getColour() : null,
            'doors' => $v instanceof Car ? $v->getDoors() : null,
            'category' => $v instanceof Car ? $v->getCategory()?->value : null,
            'load_capacity' => $v instanceof Trailer ? $v->getLoadCapacity() : null,
            'axles' => $v instanceof Trailer ? $v->getAxles() : null,
            'beds' => $v instanceof Truck ? $v->getBeds() : null,
        ];
    }

    /**
     * Map the properties and build an array with them
     *
     * @param array $vehicles
     * @return array
     */
    public function serializeCollection(array $vehicles): array
    {
        return array_map(fn(Vehicle $v) => $this->serialize($v), $vehicles);
    }
}
