<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Motorcycle;
use App\Entity\Truck;
use App\Entity\Trailer;
use App\Entity\User;
use App\Enum\CarCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VehicleFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Seed all the available vehicles
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        /** @var User $merchant */
        $merchant = $this->getReference('user_merchant', User::class);

        // Load all the needed vehicles
        $this->loadCars(merchant: $merchant, manager: $manager);
        $this->loadMotorcycles(merchant: $merchant, manager: $manager);
        $this->loadTrucks(merchant: $merchant, manager: $manager);
        $this->loadTrailers(merchant: $merchant, manager: $manager);

        $manager->flush();
    }

    /**
     * Merchant before vehicles
     *
     * @return \class-string[]
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    /**
     * Prepare cars
     *
     * @param ObjectManager $manager
     * @param User $merchant
     * @param int $count
     * @return void
     */
    private function loadCars(ObjectManager $manager, User $merchant, int $count = 5): void
    {
        for ($i = 0; $i < $count; $i++) {
            $car = new Car();
            $car->setBrand($this->faker->company)
                ->setModel($this->faker->word)
                ->setPrice($this->faker->numberBetween(10000, 50000))
                ->setQuantity($this->faker->numberBetween(1, 10))
                ->setMerchant($merchant)
                ->setEngineCapacity($this->faker->numberBetween(1, 5))
                ->setColour($this->faker->hexColor)
                ->setDoors($this->faker->randomElement([3, 5]))
                ->setCategory($this->faker->randomElement(CarCategory::cases()));

            $manager->persist($car);
        }
    }

    /**
     * Prepare trunks
     *
     * @param ObjectManager $manager
     * @param User $merchant
     * @return void
     */
    private function loadTrucks(ObjectManager $manager, User $merchant): void
    {
        $truck = new Truck();
        $truck->setBrand('Volvo')
            ->setModel('FH16')
            ->setPrice(120000)
            ->setQuantity(2)
            ->setMerchant($merchant)
            ->setEngineCapacity($this->faker->numberBetween(1, 5))
            ->setColour($this->faker->hexColor)
            ->setBeds($this->faker->numberBetween(1, 3));

        $manager->persist($truck);
    }

    /**
     * Prepare motorcycle
     *
     * @param ObjectManager $manager
     * @param User $merchant
     * @param int $count
     * @return void
     */
    private function loadMotorcycles(ObjectManager $manager, User $merchant, int $count = 3): void
    {
        for ($i = 0; $i < $count; $i++) {
            $bike = new Motorcycle();
            $bike->setBrand($this->faker->company)
                ->setModel($this->faker->word)
                ->setPrice($this->faker->numberBetween(2000, 15000))
                ->setQuantity($this->faker->numberBetween(1, 5))
                ->setMerchant($merchant)
                ->setEngineCapacity($this->faker->numberBetween(1, 5))
                ->setColour($this->faker->hexColor);

            $manager->persist($bike);
        }
    }

    /**
     * Prepare trailers
     *
     * @param User $merchant
     * @param ObjectManager $manager
     * @return void
     */
    private function loadTrailers(User $merchant, ObjectManager $manager): void
    {
        $trailer = new Trailer();
        $trailer
            ->setBrand('Krone')
            ->setModel('Cool Liner')
            ->setPrice(30000)
            ->setQuantity(5)
            ->setAxles($this->faker->numberBetween(1, 3))
            ->setLoadCapacity($this->faker->numberBetween(10, 300))
            ->setMerchant($merchant);

        $manager->persist($trailer);
    }
}
