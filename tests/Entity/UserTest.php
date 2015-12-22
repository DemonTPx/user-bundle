<?php

namespace Demontpx\UserBundle\Entity;

use FOS\UserBundle\Model\UserInterface;

/**
 * Class UserTest
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class UserTest extends \PHPUnit_Framework_TestCase 
{
    public function testUserInstanceOfUserInterface()
    {
        $user = new User();

        $this->assertInstanceOf(UserInterface::class, $user);
    }

    public function testUserFullname()
    {
        $user = new User();

        $user->setUsername('bert');
        $this->assertSame('bert', $user->getFullName());

        $user->setFullName('Bert Hekman');
        $this->assertSame('Bert Hekman', $user->getFullName());
    }
}

