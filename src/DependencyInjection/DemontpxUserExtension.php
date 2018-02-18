<?php

namespace Demontpx\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @copyright 2015 Bert Hekman
 */
class DemontpxUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $root = 'demontpx_user.';

        $container->setParameter($root . 'roles', $config['roles']);
        $container->setParameter($root . 'fixtures', $config['fixtures']);

        $container->setParameter($root . 'gravatar.default_size', $config['gravatar']['default_size']);
        $container->setParameter($root . 'gravatar.default_rating', $config['gravatar']['default_rating']);
        $container->setParameter($root . 'gravatar.default_default', $config['gravatar']['default_default']);
        $container->setParameter($root . 'gravatar.default_force_default', $config['gravatar']['default_force_default']);

        $container->setAlias($root . 'object_manager', $config['orm_entity_manager']);
    }
}
