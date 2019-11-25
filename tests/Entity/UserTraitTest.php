<?php declare(strict_types=1);

namespace Demontpx\UserBundle\Entity;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
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
     * @return MockObject|User
     */
    private function createUserMock()
    {
        return $this->createMock(User::class);
    }
}
