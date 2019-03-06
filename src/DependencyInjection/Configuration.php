<?php

namespace Demontpx\UserBundle\DependencyInjection;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @copyright 2015 Bert Hekman
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('demontpx_user');

        // For BC with symfony/config < 4.2
        if (method_exists($treeBuilder, 'getRootNode')) {
            /** @var ArrayNodeDefinition $rootNode */
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $rootNode = $treeBuilder->root('demontpx_user');
        }

        $rootNode
            ->children()
                ->scalarNode('orm_entity_manager')->defaultValue(EntityManagerInterface::class)->end()
                ->arrayNode('roles')
                    ->info('Defines the roles that can be selected during user management')
                    ->example(['ROLE_USER', 'ROLE_ADMIN'])
                    ->treatNullLike([])
                    ->variablePrototype()->end()
                ->end()
                ->arrayNode('fixtures')
                    ->info('Data fixtures which will be created; Users will get the same password as their username')
                    ->treatNullLike([])
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->arrayNode('roles')
                                ->example(['ROLE_USER', 'ROLE_ADMIN'])
                                ->scalarPrototype()->end()
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
