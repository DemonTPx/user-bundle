<?php

namespace Demontpx\UserBundle\Service;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Exception\UserNotFoundException;
use Demontpx\UserBundle\Model\UserInterface;
use Demontpx\UserBundle\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @copyright 2018 Bert Hekman
 */
class UserManager implements UserManagerInterface
{
    /** @var ObjectManager */
    private $objectManager;

    /** @var UserRepository */
    private $repository;

    /** @var PasswordUpdaterInterface */
    private $passwordUpdater;

    public function __construct(
        ObjectManager $entityManager,
        UserRepository $repository,
        PasswordUpdaterInterface $passwordUpdater
    )
    {
        $this->objectManager = $entityManager;
        $this->repository = $repository;
        $this->passwordUpdater = $passwordUpdater;
    }

    public function createUser(): UserInterface
    {
        return new User();
    }

    public function deleteUser(UserInterface $user)
    {
        $this->objectManager->remove($user);
        $this->objectManager->flush();
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

    public function updateUser(UserInterface $user)
    {
        $this->updatePassword($user);

        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }

    public function updatePassword(UserInterface $user)
    {
        $this->passwordUpdater->hashPassword($user);
    }
}
