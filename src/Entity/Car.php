<?php

namespace App\Entity;

use App\Enum\CarCategory;
use App\Repository\CarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car extends Vehicle
{
    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1)]
    private ?string $engine_capacity = null;

    #[ORM\Column(length: 50)]
    private ?string $colour = null;

    #[ORM\Column]
    private ?int $doors = null;

    #[ORM\Column(enumType: CarCategory::class)]
    private ?CarCategory $category = null;

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

    public function getDoors(): ?int
    {
        return $this->doors;
    }

    public function setDoors(int $doors): static
    {
        $this->doors = $doors;

        return $this;
    }

    public function getCategory(): ?CarCategory
    {
        return $this->category;
    }

    public function setCategory(CarCategory $category): static
    {
        $this->category = $category;

        return $this;
    }
}
