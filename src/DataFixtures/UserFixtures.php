<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public const MERCHANT_USER_REF = 'user_merchant';
    public const BUYER_USER_REF = 'user_buyer';

    /**
     * @param UserPasswordHasherInterface $hasher
     */
    public function __construct(private UserPasswordHasherInterface $hasher)
    {}

    /**
     * User seeder
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // User with merchant role
        $merchantUser = new User();
        $merchantUser->setEmail(self::MERCHANT_USER_REF . '@mypos.com');
        $merchantUser->setPassword(
            $this->hasher->hashPassword($merchantUser, 'password')
        );
        $merchantUser->setFirstName($faker->firstName);
        $merchantUser->setLastName($faker->lastName);
        $merchantUser->setRole(
            $this->getReference(RoleFixtures::MERCHANT_ROLE_REF, Role::class)
        );
        $manager->persist($merchantUser);
        $this->addReference(self::MERCHANT_USER_REF, $merchantUser);

        // User with buyer role
        $buyerUser = new User();
        $buyerUser->setEmail(self::BUYER_USER_REF . '@mypos.com');
        $buyerUser->setPassword(
            $this->hasher->hashPassword($buyerUser, 'password')
        );
        $buyerUser->setFirstName($faker->firstName);
        $buyerUser->setLastName($faker->lastName);
        $buyerUser->setRole(
            $this->getReference(RoleFixtures::BUYER_ROLE_REF, Role::class)
        );
        $manager->persist($buyerUser);
        $this->addReference(self::BUYER_USER_REF, $buyerUser);

        // Prepare and create
        $manager->flush();
    }

    /**
     * Load Role before User
     *
     * @return \class-string[]
     */
    public function getDependencies(): array
    {
        return [
            RoleFixtures::class,
        ];
    }
}
