<?php

namespace AshleyDawson\GlideBundle;

use AshleyDawson\GlideBundle\DependencyInjection\Container\ManipulatorCollectionCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AshleyDawsonGlideBundle
 *
 * @package AshleyDawson\GlideBundle
 */
class AshleyDawsonGlideBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ManipulatorCollectionCompilerPass());
    }
}