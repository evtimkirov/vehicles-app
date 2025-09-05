<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixtures extends Fixture
{
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
        $merchant->setName(UserFixtures::MERCHANT_ROLE_REF);
        $manager->persist($merchant);
        $manager->flush();

        // Bayer role
        $buyer = new Role();
        $buyer->setName(UserFixtures::BUYER_ROLE_REF);
        $manager->persist($buyer);
        $manager->flush();

        // References
        $this->addReference(UserFixtures::MERCHANT_ROLE_REF, $merchant);
        $this->addReference(UserFixtures::BUYER_ROLE_REF, $buyer);
    }
}
