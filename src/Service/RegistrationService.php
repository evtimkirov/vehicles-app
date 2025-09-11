<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationService
{
    /**
     * @param EntityManagerInterface $manager
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(
        private EntityManagerInterface $manager,
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    /**
     * Create a new user
     *
     * @param array $data
     * @param Role $role
     * @return User
     */
    public function registerUser(array $data, Role $role): User
    {
        $user = new User();
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setRole($role);

        $this->manager->persist($user);
        $this->manager->flush();

        return $user;
    }
}
