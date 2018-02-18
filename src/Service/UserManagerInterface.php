<?php

namespace Demontpx\UserBundle\Service;

use Demontpx\UserBundle\Model\UserInterface;

/**
 * @copyright 2018 Bert Hekman
 */
interface UserManagerInterface
{
    public function createUser(): UserInterface;
    public function deleteUser(UserInterface $user);
    public function findUserBy(array $criteria): UserInterface;
    public function findUserByUsername(string $username): UserInterface;
    public function findUserByEmail(string $email): UserInterface;
    /**
     * @return \Traversable|UserInterface[]
     */
    public function findUserList();
    public function reloadUser(UserInterface $user);
    public function updateUser(UserInterface $user);
    public function updatePassword(UserInterface $user);
}
