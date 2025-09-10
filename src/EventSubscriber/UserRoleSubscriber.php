<?php


namespace App\EventSubscriber;

use App\Entity\User;
use App\Repository\RoleRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class UserRoleSubscriber implements EventSubscriber
{
    public function __construct(private RoleRepository $roleRepository)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [Events::prePersist];
    }

    /**
     * Set default buyer role when create
     *
     * @param User $user
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function prePersist(User $user, LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return;
        }

        // If run seeders
        if ($user->getRole() !== null) {
            return;
        }

        if ($entity->getRole() === null) {
            $defaultRole = $this->roleRepository->findOneBy(['name' => 'ROLE_BUYER']);
            $entity->setRole($defaultRole);
        }
    }
}
