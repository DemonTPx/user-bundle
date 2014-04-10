<?php

namespace Demontpx\UserBundle\Tests\Entity;

use Demontpx\UserBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;

/**
 * Class UserTest
 *
 * @package   Demontpx\UserBundle\Tests\Entity
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

