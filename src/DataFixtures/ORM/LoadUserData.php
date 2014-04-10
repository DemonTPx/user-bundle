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
 * @package   Demontpx\UserBundle\DataFixtures\ORM
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ObjectManager */
    private $manager;

    /** @var ContainerInterface */
    private $container;

    /**
     * {@inheritDoc}
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $userList = $this->container->getParameter('demontpx_user.fixtures');

        foreach ($userList as $username => $data) {
            $this->persistUser($username, $data['roles']);
        }

        $manager->flush();
    }

    /**
     * @param string   $username
     * @param string[] $roleList
     *
     * @return User
     */
    private function persistUser($username, array $roleList = array())
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

    /**
     * {@inheritDoc}
     */
    function getOrder()
    {
        return 10;
    }

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
