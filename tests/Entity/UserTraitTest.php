<?php

namespace Demontpx\UserBundle\Entity;

use PHPUnit\Framework\TestCase;

/**
 * Class UserTraitTest
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class UserTraitTest extends TestCase
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
        return $this->createMock(User::class);
    }
}
