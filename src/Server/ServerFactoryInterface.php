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
     * Get a Glide server with source and cache filesystems
     *
     * @param FilesystemInterface $source
     * @param FilesystemInterface $cache
     * @return \League\Glide\Server
     */
    public function getServer(FilesystemInterface $source, FilesystemInterface $cache);
}