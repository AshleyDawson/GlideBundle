<?php

namespace AshleyDawson\GlideBundle\Server;

use League\Flysystem\FilesystemInterface;

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
     * @param FilesystemInterface $source
     * @param FilesystemInterface $cache
     * @return \AshleyDawson\GlideBundle\Server\Server;
     */
    public function create(FilesystemInterface $source, FilesystemInterface $cache);
}