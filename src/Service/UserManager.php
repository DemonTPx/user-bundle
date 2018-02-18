<?php

namespace Demontpx\UserBundle\Service;

use Demontpx\UserBundle\Entity\User;
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
        return $this->repository->findOneBy($criteria);
    }

    public function findUserByUsername(string $username): UserInterface
    {
        return $this->repository->findOneBy(['username' => $username]);
    }

    public function findUserByEmail(string $email): UserInterface
    {
        return $this->repository->findOneBy(['email' => $email]);
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
