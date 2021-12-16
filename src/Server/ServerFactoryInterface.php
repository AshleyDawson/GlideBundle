<?php

namespace AshleyDawson\GlideBundle\Server;

use League\Flysystem\FilesystemOperator;

/**
 * Interface ServerFactoryInterface
 *
 * @package AshleyDawson\GlideBundle\Server
 */
interface ServerFactoryInterface
{
    /**
     * Create a Glide server with source and cache filesystems
     *
     * @param FilesystemOperator $source
     * @param FilesystemOperator $cache
     * @return \AshleyDawson\GlideBundle\Server\Server;
     */
    public function create(FilesystemOperator $source, FilesystemOperator $cache): Server;
}
