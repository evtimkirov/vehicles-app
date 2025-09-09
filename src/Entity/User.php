<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use App\Controller\Api\Admin\UserController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Controller\Api\RegistrationController;
use App\Controller\Api\LoginController;
use App\Controller\Api\ForgottenPasswordController;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
#[ApiResource(
    operations: [
        new Post(uriTemplate: '/registration', controller: RegistrationController::class),
        new Post(uriTemplate: '/login', controller: LoginController::class),
        new Post(uriTemplate: '/forgotten-password', controller: ForgottenPasswordController::class),
        new Get(),
        new Get(uriTemplate: '/users/{id}/vehicles', controller: UserController::class . '::getUserVehicles')
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true, nullable: false)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: false)]
    private ?string $password = null;

    #[ORM\Column(length: 50, nullable: false)]
    private ?string $first_name = null;

    #[ORM\Column(length: 50, nullable: false)]
    private ?string $last_name = null;

    #[ORM\ManyToOne(targetEntity: Role::class, inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Role $role = null;

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'merchant')]
    private Collection $vehicles;

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\ManyToMany(targetEntity: Vehicle::class)]
    #[ORM\JoinTable(name: "followed_vehicles")]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "vehicle_id", referencedColumnName: "id", onDelete: "CASCADE")]
    private Collection $followedVehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->followedVehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return [$this->role?->getName() ?? 'ROLE_USER'];
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setMerchant($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            if ($vehicle->getMerchant() === $this) {
                $vehicle->setMerchant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getFollowedVehicles(): Collection
    {
        return $this->followedVehicles;
    }

    public function addFollowedVehicle(Vehicle $vehicle): static
    {
        if (!$this->followedVehicles->contains($vehicle)) {
            $this->followedVehicles->add($vehicle);
        }

        return $this;
    }

    public function removeFollowedVehicle(Vehicle $vehicle): static
    {
        $this->followedVehicles->removeElement($vehicle);

        return $this;
    }

    public function eraseCredentials(): void
    {
        // no-op
    }
}
