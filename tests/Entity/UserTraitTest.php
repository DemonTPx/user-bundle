<?php

namespace Demontpx\UserBundle\Entity;

/**
 * Class UserTraitTest
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class UserTraitTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $trait = new UserTraitImpl();

        $user = $this->createUserMock();

        $trait->setUser($user);
        $this->assertEquals($user, $trait->getUser());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|User
     */
    private function createUserMock()
    {
        return $this->getMock(User::class);
    }
}
