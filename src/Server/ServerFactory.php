<?php

namespace AshleyDawson\GlideBundle\Server;

use League\Flysystem\FilesystemInterface;
use League\Glide\Api\ApiInterface;

/**
 * Class ServerFactory
 *
 * @package AshleyDawson\GlideBundle\Server
 */
class ServerFactory implements ServerFactoryInterface
{
    /**
     * @var ApiInterface
     */
    private $_api;

    /**
     * Constructor
     *
     * @param ApiInterface $api
     */
    public function __construct(ApiInterface $api)
    {
        $this->_api = $api;
    }

    /**
     * {@inheritdoc}
     */
    public function create(FilesystemInterface $source, FilesystemInterface $cache)
    {
        return new Server($source, $cache, $this->_api);
    }
}