<?php

namespace AshleyDawson\GlideBundle\Server;

use League\Flysystem\FilesystemInterface;
use League\Glide\Server;
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
     * @var bool
     */
    private $_canReturnNewInstance;

    /**
     * @var Server[]
     */
    private static $_serverRegistry = [];

    /**
     * Constructor
     *
     * @param ApiInterface $api
     * @param bool $canReturnNewInstance If TRUE factory always returns a new instance
     */
    public function __construct(ApiInterface $api, $canReturnNewInstance = false)
    {
        $this->_api = $api;
        $this->_canReturnNewInstance = $canReturnNewInstance;
    }

    /**
     * {@inheritdoc}
     */
    public function getServer(FilesystemInterface $source, FilesystemInterface $cache)
    {
        $registryKey = $this->_buildRegistryKey($source, $cache);

        if (isset(self::$_serverRegistry[$registryKey]) && ( ! $this->_canReturnNewInstance)) {
            return self::$_serverRegistry[$registryKey];
        }

        return self::$_serverRegistry[$registryKey] = new Server($source, $cache, $this->_api);
    }

    /**
     * Build a key for the server registry based on the
     * filesystems and API
     *
     * @param FilesystemInterface $source
     * @param FilesystemInterface $cache
     * @return string
     */
    private function _buildRegistryKey(FilesystemInterface $source, FilesystemInterface $cache)
    {
        return md5(spl_object_hash($source) . spl_object_hash($cache) . spl_object_hash($this->_api));
    }
}