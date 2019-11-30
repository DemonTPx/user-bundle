<?php declare(strict_types=1);

namespace Demontpx\UserBundle\DataFixtures;

use Demontpx\UserBundle\Entity\User;
use Demontpx\UserBundle\Service\UserManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @copyright 2018 Bert Hekman
 */
class UserFixtures extends Fixture
{
    private UserManagerInterface $userManager;
    private array $userList;
    private ObjectManager $manager;

    public function __construct(UserManagerInterface $userManager, array $userList)
    {
        $this->userManager = $userManager;
        $this->userList = $userList;
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        foreach ($this->userList as $username => $data) {
            $this->persistUser($username, $data['roles']);
        }

        $manager->flush();
    }

    private function persistUser(string $username, array $roleList = []): User
    {
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setPlainPassword($username);
        $user->setEmail($username . '@example.local');
        $user->setRoleList($roleList);
        $user->setEnabled(true);

        $this->setReference('user-' . $username, $user);

        $this->userManager->updateUser($user);

        return $user;
    }
}
