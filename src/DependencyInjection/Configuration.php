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
                ->arrayNode('gravatar')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default_size')->defaultValue(80)->end()
                        ->enumNode('default_rating')->defaultValue('g')->values(['g', 'pg', 'r', 'x'])->end()
                        ->scalarNode('default_default')->defaultValue('mm')->end()
                        ->booleanNode('default_force_default')->defaultFalse()->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
