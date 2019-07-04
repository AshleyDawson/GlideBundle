<?php

namespace AshleyDawson\GlideBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Class Configuration
 *
 * @package AshleyDawson\GlideBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('ashley_dawson_glide');
        $rootNode = \method_exists($treeBuilder, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root('ashley_dawson_glide');

        $rootNode
            ->children()
                ->integerNode('max_image_size')->defaultValue(4000000)->end()
                ->scalarNode('image_manager_driver')->defaultValue('gd')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
