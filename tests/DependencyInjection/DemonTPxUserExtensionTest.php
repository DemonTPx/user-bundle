<?php declare(strict_types=1);

namespace Demontpx\UserBundle\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @copyright 2014 Bert Hekman
 */
class DemontpxUserExtensionTest extends TestCase
{
    private DemontpxUserExtension $extension;
    private string $root;

    public function setUp(): void
    {
        parent::setUp();

        $this->extension = $this->getExtension();
        $this->root = 'demontpx_user.';
    }

    public function testCorrectRoot()
    {
        $container = new ContainerBuilder();
        $this->extension->load([], $container);

        foreach (array_keys($container->getDefinitions()) as $id) {
            if ($id === 'service_container') {
                continue;
            }
            if (strpos($id, '\\') !== false) {
                $this->assertStringStartsWith('Demontpx\\UserBundle\\', $id);

                continue;
            }
            $this->assertStringStartsWith($this->root, $id);
        }
        foreach (array_keys($container->getAliases()) as $id) {
            if (strpos($id, '\\') !== -1) {
                continue;
            }
            $this->assertStringStartsWith($this->root, $id);
        }
        foreach (array_keys($container->getParameterBag()->all()) as $id) {
            $this->assertStringStartsWith($this->root, $id);
        }
    }

    public function testDefaultValues()
    {
        $container = new ContainerBuilder();
        $this->extension->load([], $container);

        $this->assertTrue($container->hasParameter($this->root . 'roles'));
        $this->assertEquals([], $container->getParameter($this->root . 'roles'));

        $this->assertTrue($container->hasParameter($this->root . 'fixtures'));
        $this->assertEquals([], $container->getParameter($this->root . 'fixtures'));
    }

    public function testRoles()
    {
        $config = [[
            'roles' => [
                'ROLE_ADMIN' => 'Administrator',
                'ROLE_GROUP_MANAGER' => 'Group manager',
            ],
        ]];

        $container = new ContainerBuilder();
        $this->extension->load($config, $container);

        $this->assertTrue($container->hasParameter($this->root . 'roles'));
        $this->assertEquals($config[0]['roles'], $container->getParameter($this->root . 'roles'));
    }

    public function testFixtures()
    {
        $config = [[
            'fixtures' => [
                'user' => null,
                'admin' => ['roles' => ['ROLE_ADMIN']],
                'super' => ['roles' => ['ROLE_ADMIN', 'ROLE_SUPER']],
            ],
        ]];

        $container = new ContainerBuilder();
        $this->extension->load($config, $container);

        $this->assertTrue($container->hasParameter($this->root . 'fixtures'));

        $fixtures = $container->getParameter($this->root . 'fixtures');

        $this->assertTrue(is_array($fixtures));
        $this->assertCount(3, $fixtures);
        $this->assertArrayHasKey('user', $fixtures);

        $this->assertEquals([], $fixtures['user']['roles']);
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_SUPER'], $fixtures['super']['roles']);
    }

    protected function getExtension(): DemontpxUserExtension
    {
        return new DemontpxUserExtension();
    }
}

