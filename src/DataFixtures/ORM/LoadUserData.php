<?php

namespace Demontpx\UserBundle\DataFixtures\ORM;

use Demontpx\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ObjectManager */
    private $manager;

    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $userList = $this->container->getParameter('demontpx_user.fixtures');

        foreach ($userList as $username => $data) {
            $this->persistUser($username, $data['roles']);
        }

        $manager->flush();
    }

    private function persistUser(string $username, array $roleList = array()): User
    {
        $user = new User();
        $user->setUsername($username);
        $user->setPlainPassword($username);
        $user->setEmail($username . '@example.local');
        $user->setRoles($roleList);
        $user->setEnabled(true);

        $this->setReference('user-' . $username, $user);

        $this->manager->persist($user);

        return $user;
    }

    public function getOrder()
    {
        return 10;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
