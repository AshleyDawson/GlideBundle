<?php

namespace AshleyDawson\GlideBundle\DependencyInjection\Container;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ManipulatorCollectionCompilerPass
 *
 * @package AshleyDawson\GlideBundle\DependencyInjection\Container
 */
class ManipulatorCollectionCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if ( ! $container->has('ashleydawson.glide.manipulator_collection')) {
            return;
        }

        $definition = $container->findDefinition(
            'ashleydawson.glide.manipulator_collection'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'ashleydawson.glide.manipulators'
        );

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall(
                'addManipulator',
                [new Reference($id)]
            );
        }
    }
}
