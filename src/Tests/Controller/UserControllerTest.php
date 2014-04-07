<?php

namespace DemonTPx\UserBundle\Tests\Controller;

use DemonTPx\UtilBundle\Tests\UserClientTrait;
use DemonTPx\UtilBundle\Tests\UserWebTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class UserControllerTest
 *
 * @package   DemonTPx\UserBundle\Tests\Controller
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class UserControllerTest extends UserWebTestCase
{
    /**
     * Test index forbidden for non admin
     */
    public function testIndexForbiddenForNonAdmin()
    {
        $client = static::createClientForUser('user');

        $client->request('GET', '/user/');
        $this->assertTrue($client->getResponse()->isForbidden());
    }
}

