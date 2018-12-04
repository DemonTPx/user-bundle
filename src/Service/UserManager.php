<?php

namespace Demontpx\UserBundle\Service;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Events\UserEvent;
use Demontpx\UserBundle\Events\UserEvents;
use Demontpx\UserBundle\Exception\UserNotFoundException;
use Demontpx\UserBundle\Model\UserInterface;
use Demontpx\UserBundle\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @copyright 2018 Bert Hekman
 */
class UserManager implements UserManagerInterface
{
    /** @var EntityManagerInterface */
    private $objectManager;
    /** @var UserRepository */
    private $repository;
    /** @var PasswordUpdaterInterface */
    private $passwordUpdater;
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $repository,
        PasswordUpdaterInterface $passwordUpdater,
        EventDispatcherInterface $eventDispatcher
    )
    {
        $this->objectManager = $entityManager;
        $this->repository = $repository;
        $this->passwordUpdater = $passwordUpdater;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createUser(): UserInterface
    {
        return new User();
    }

    public function updateUser(UserInterface $user)
    {
        $new = $user->getId() === null;

        $this->updatePassword($user);

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        $this->dispatchEvent($new ? UserEvents::CREATED : UserEvents::UPDATED, $user);
    }

    public function updatePassword(UserInterface $user)
    {
        $this->passwordUpdater->hashPassword($user);
    }

    public function deleteUser(UserInterface $user)
    {
        $id = $user->getId();
        $username = $user->getUsername();

        $this->objectManager->remove($user);
        $this->objectManager->flush();

        $this->dispatchEvent(UserEvents::DELETED, $user, $id, $username);
    }

    public function findUserBy(array $criteria): UserInterface
    {
        $user = $this->repository->findOneBy($criteria);

        if ( ! $user) {
            throw new UserNotFoundException(sprintf('User with criteria "%s" not found', json_encode($criteria)));
        }

        return $user;
    }

    public function findUserByUsername(string $username): UserInterface
    {
        $user = $this->repository->findOneBy(['username' => $username]);

        if ( ! $user) {
            throw new UserNotFoundException(sprintf('User with username "%s" not found', $username));
        }

        return $user;
    }

    public function findUserByEmail(string $email): UserInterface
    {
        $user = $this->repository->findOneBy(['email' => $email]);

        if ( ! $user) {
            throw new UserNotFoundException(sprintf('User with email "%s" not found', $email));
        }

        return $user;
    }

    /**
     * @return \Traversable|UserInterface[]
     */
    public function findUserList()
    {
        return $this->repository->findAll();
    }

    public function reloadUser(UserInterface $user)
    {
        $this->objectManager->refresh($user);
    }

    private function dispatchEvent(string $eventName, UserInterface $user, ?int $id = null, ?string $username = null): UserEvent
    {
        $event = new UserEvent($user, $id ?? $user->getId(), $username ?? $user->getUsername());
        $this->eventDispatcher->dispatch($eventName, $event);

        return $event;
    }
}
