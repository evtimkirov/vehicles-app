<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    /**
     * Merchant role
     */
    public const MERCHANT_ROLE_REF = 'role_merchant';

    /**
     * Buyer role
     */
    public const BUYER_ROLE_REF = 'role_buyer';

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
        $merchantUser->setEmail(self::MERCHANT_ROLE_REF . '@mypos.com');
        $merchantUser->setPassword(
            $this->hasher->hashPassword($merchantUser, 'password')
        );
        $merchantUser->setFirstName($faker->firstName);
        $merchantUser->setLastName($faker->lastName);
        $merchantUser->setRole(
            $this->getReference(self::MERCHANT_ROLE_REF, Role::class)
        );

        // User with buyer role
        $buyerUser = new User();
        $buyerUser->setEmail(self::BUYER_ROLE_REF . '@mypos.com');
        $buyerUser->setPassword(
            $this->hasher->hashPassword($buyerUser, 'password')
        );
        $buyerUser->setFirstName($faker->firstName);
        $buyerUser->setLastName($faker->lastName);
        $buyerUser->setRole(
            $this->getReference(self::BUYER_ROLE_REF, Role::class)
        );

        // Prepare and create
        $manager->persist($merchantUser);
        $manager->persist($buyerUser);
        $manager->flush();
    }
}
