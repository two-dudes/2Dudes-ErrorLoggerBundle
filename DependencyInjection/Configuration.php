<?php

namespace TwoDudes\ErrorLoggerBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('two_dudes');

        $rootNode
            ->children()
                ->arrayNode('error_logger')
                    ->children()
                        ->arrayNode('storage')
                            ->children()
                                ->scalarNode('service')->end()
                                ->arrayNode('params')
                                    ->children()
                                        ->scalarNode('db_host')->end()
                                        ->scalarNode('db_port')->end()
                                        ->scalarNode('db_name')->end()
                                        ->scalarNode('db_user')->end()
                                        ->scalarNode('db_password')->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->scalarNode('log404')->defaultValue(true)->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
