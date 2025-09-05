<?php

namespace App\Entity;

use App\Repository\TrailerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrailerRepository::class)]
class Trailer extends Vehicle
{
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $load_capacity = null;

    #[ORM\Column(type: Types::INTEGER)]
    private ?int $axles = null;

    public function getLoadCapacity(): ?int
    {
        return $this->load_capacity;
    }

    public function setLoadCapacity(int $load_capacity): static
    {
        $this->load_capacity = $load_capacity;

        return $this;
    }

    public function getAxles(): ?int
    {
        return $this->axles;
    }

    public function setAxles(int $axles): static
    {
        $this->axles = $axles;

        return $this;
    }
}
