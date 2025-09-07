<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Vehicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class FollowedVehicleFixtures extends Fixture implements DependentFixtureInterface
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Add followed vehicles
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $vehicles = $manager->getRepository(Vehicle::class)->findAll();

        /** @var User $buyer */
        $buyer = $this->getReference(UserFixtures::BUYER_USER_REF, User::class);

        $followed = $this->faker->randomElements($vehicles, rand(1, 3));

        foreach ($followed as $vehicle) {
            $buyer->addFollowedVehicle($vehicle);
        }

        $manager->flush();
    }

    /**
     * Get User and Vehicle before the Followed vehicles
     *
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            VehicleFixtures::class,
        ];
    }
}
