<?php

namespace Demontpx\UserBundle\Tests\DependencyInjection;

use Demontpx\UserBundle\DependencyInjection\DemontpxUserExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class DemontpxUserExtensionTest
 *
 * @package   Demontpx\UserBundle\Tests\DependencyInjection
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2014 Bert Hekman
 */
class DemontpxUserExtensionTest extends \PHPUnit_Framework_TestCase
{
    /** @var DemontpxUserExtension */
    private $extension;

    /** @var string */
    private $root;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->extension = $this->getExtension();
        $this->root = 'demontpx_user.';
    }

    /**
     * Test default values
     */
    public function testDefaultValues()
    {
        $container = new ContainerBuilder();
        $this->extension->load(array(), $container);

        $this->assertTrue($container->hasParameter($this->root . 'roles'));
        $this->assertEquals(array(), $container->getParameter($this->root . 'roles'));

        $this->assertTrue($container->hasParameter($this->root . 'fixtures'));
        $this->assertEquals(array(), $container->getParameter($this->root . 'fixtures'));
    }

    /**
     * Test roles
     */
    public function testRoles()
    {
        $config = array(array(
            'roles' => array(
                'ROLE_ADMIN' => 'Administrator',
                'ROLE_GROUP_MANAGER' => 'Group manager',
            )
        ));

        $container = new ContainerBuilder();
        $this->extension->load($config, $container);

        $this->assertTrue($container->hasParameter($this->root . 'roles'));
        $this->assertEquals($config[0]['roles'], $container->getParameter($this->root . 'roles'));
    }

    /**
     * Test fixtures
     */
    public function testFixtures()
    {
        $config = array(array(
            'fixtures' => array(
                'user' => null,
                'admin' => array('roles' => array('ROLE_ADMIN')),
                'super' => array('roles' => array('ROLE_ADMIN', 'ROLE_SUPER')),
            )
        ));

        $container = new ContainerBuilder();
        $this->extension->load($config, $container);

        $this->assertTrue($container->hasParameter($this->root . 'fixtures'));

        $fixtures = $container->getParameter($this->root . 'fixtures');

        $this->assertTrue(is_array($fixtures));
        $this->assertCount(3 , $fixtures);
        $this->assertArrayHasKey('user', $fixtures);

        $this->assertEquals(array(), $fixtures['user']['roles']);
        $this->assertEquals(array('ROLE_ADMIN', 'ROLE_SUPER'), $fixtures['super']['roles']);
    }

    /**
     * Returns the Configuration to test
     *
     * @return DemontpxUserExtension
     */
    protected function getExtension()
    {
        return new DemontpxUserExtension();
    }
}

