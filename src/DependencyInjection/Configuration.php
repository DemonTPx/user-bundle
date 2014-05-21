<?php

namespace Demontpx\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('demontpx_user');

        $rootNode
            ->children()
                ->arrayNode('roles')
                    ->info('Defines the roles that can be selected during user management')
                    ->example(array('ROLE_USER', 'ROLE_ADMIN'))
                    ->treatNullLike(array())
                    ->prototype('variable')->end()
                ->end()
                ->arrayNode('fixtures')
                    ->info('Data fixtures which will be created; Users will get the same password as their username')
                    ->treatNullLike(array())
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('roles')
                                ->example(array('ROLE_USER', 'ROLE_ADMIN'))
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
