<?php

namespace DemonTPx\UserBundle\DataFixtures\ORM;

use DemonTPx\UserBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 *
 * @package   DemonTPx\UserBundle\DataFixtures\ORM
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /** @var ObjectManager */
    private $manager;

    /**
     * {@inheritDoc}
     */
    function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->persistUser('user');
        $this->persistUser('test');
        $this->persistUser('admin', array('ROLE_ADMIN'));

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    function getOrder()
    {
        return 10;
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
}
