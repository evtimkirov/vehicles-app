<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
    public const MERCHANT_ROLE_REF = 'role_merchant';
    public const BUYER_ROLE_REF = 'role_buyer';

    /**
     * Role seeder
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Merchant role
        $merchant = new Role();
        $merchant->setName(self::MERCHANT_ROLE_REF);
        $manager->persist($merchant);
        $this->addReference(self::MERCHANT_ROLE_REF, $merchant);

        // Bayer role
        $buyer = new Role();
        $buyer->setName(self::BUYER_ROLE_REF);
        $manager->persist($buyer);
        $this->addReference(self::BUYER_ROLE_REF, $buyer);

        // Execute
        $manager->flush();
    }
}
