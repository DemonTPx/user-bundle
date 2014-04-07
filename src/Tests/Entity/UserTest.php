<?php

namespace DemonTPx\UserBundle\Tests\Entity;

use DemonTPx\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;

/**
 * Class UserTest
 *
 * @package   DemonTPx\UserBundle\Tests\Entity
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class UserTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * Assert that User is an instance of UserInterface
     */
    public function testUserInstanceOfUserInterface()
    {
        $user = new User();

        $this->assertInstanceOf(UserInterface::class, $user);
    }
}

