<?php

namespace AshleyDawson\GlideBundle\Tests;

use AshleyDawson\GlideBundle\DependencyInjection\AshleyDawsonGlideExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;

/**
 * Class AshleyDawsonGlideBundleTest
 *
 * @package AshleyDawson\GlideBundle\Tests
 */
class AshleyDawsonGlideBundleTest extends AbstractExtensionTestCase
{
    public function testContainerGetGlideServerFactory()
    {
        $this->load();

        $this->assertContainerBuilderHasService('ashleydawson.glide.server_factory');
    }

    /**
     * Return an array of container extensions you need to be registered for each test (usually just the container
     * extension you are testing.
     *
     * @return ExtensionInterface[]
     */
    protected function getContainerExtensions()
    {
        return [
            new AshleyDawsonGlideExtension(),
        ];
    }
}