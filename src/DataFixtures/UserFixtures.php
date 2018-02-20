<?php

namespace Demontpx\UserBundle\DataFixtures;

use Demontpx\UserBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @copyright 2018 Bert Hekman
 */
class UserFixtures extends Fixture
{
    /** @var ObjectManager */
    private $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $userList = $this->container->getParameter('demontpx_user.fixtures');

        foreach ($userList as $username => $data) {
            $this->persistUser($username, $data['roles']);
        }

        $manager->flush();
    }

    private function persistUser(string $username, array $roleList = []): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPlainPassword($username);
        $user->setEmail($username . '@example.local');
        $user->setRoleList($roleList);
        $user->setEnabled(true);

        $this->setReference('user-' . $username, $user);

        $this->manager->persist($user);

        return $user;
    }
}
