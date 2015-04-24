<?php

namespace AshleyDawson\GlideBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Processor;

/**
 * Class AshleyDawsonGlideExtension
 *
 * @package AshleyDawson\GlideBundle\DependencyInjection
 */
class AshleyDawsonGlideExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $processor = new Processor();

        $config = $processor->processConfiguration($configuration, $config);

        $container->setParameter('ashleydawson.glide.max_image_size',
            $config['max_image_size']);

        $container->setParameter('ashleydawson.glide.image_manager_driver',
            $config['image_manager_driver']);

        $container->setParameter('ashleydawson.glide.create_new_server_instance',
            $config['create_new_server_instance']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');
    }
}