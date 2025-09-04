<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TruckRepository::class)]
class Truck extends Vehicle
{
    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1)]
    private ?string $engine_capacity = null;

    #[ORM\Column(length: 50)]
    private ?string $colour = null;

    #[ORM\Column]
    private ?int $beds = null;

    public function getEngineCapacity(): ?string
    {
        return $this->engine_capacity;
    }

    public function setEngineCapacity(string $engine_capacity): static
    {
        $this->engine_capacity = $engine_capacity;

        return $this;
    }

    public function getColour(): ?string
    {
        return $this->colour;
    }

    public function setColour(string $colour): static
    {
        $this->colour = $colour;

        return $this;
    }

    public function getBeds(): ?int
    {
        return $this->beds;
    }

    public function setBeds(int $beds): static
    {
        $this->beds = $beds;

        return $this;
    }
}
