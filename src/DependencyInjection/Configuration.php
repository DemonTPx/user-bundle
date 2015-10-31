<?php

namespace Demontpx\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
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
                    ->example(['ROLE_USER', 'ROLE_ADMIN'])
                    ->treatNullLike([])
                    ->prototype('variable')->end()
                ->end()
                ->arrayNode('fixtures')
                    ->info('Data fixtures which will be created; Users will get the same password as their username')
                    ->treatNullLike([])
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->arrayNode('roles')
                                ->example(['ROLE_USER', 'ROLE_ADMIN'])
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
