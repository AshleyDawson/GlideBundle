<?php

namespace AshleyDawson\GlideBundle\Server;

use League\Glide\Server as GlideServer;

/**
 * Class Server
 *
 * @package AshleyDawson\GlideBundle\Server
 */
class Server extends GlideServer
{
    /**
     * @var \Closure
     */
    private $_cachePathFilter;

    /**
     * Set cache path filter - allows modification of cache path relative
     * to its self. For example:
     *
     * <code>
     * use Symfony\Component\HttpFoundation\Request;
     * use League\Flysystem\FilesystemInterface;
     *
     * $server->setCachePathFilter(function ($path, Request $request, FilesystemInterface $cache) {
     *     return '/my/custom/location' . $path;
     * });
     * </code>
     *
     * @param \Closure $cachePathFilter
     */
    public function setCachePathFilter(\Closure $cachePathFilter)
    {
        $this->_cachePathFilter = $cachePathFilter;
    }

    /**
     * {@inheritdoc}
     */
    public function getCachePath()
    {
        $request = $this->resolveRequestObject(func_get_args());

        $path = md5($this->getSourcePath($request).'?'.http_build_query($request->query->all()));

        if ($this->_cachePathFilter instanceof \Closure) {
            $filter = $this->_cachePathFilter;
            $path = $filter($path, $request, $this->getCache());
        }

        if ($this->cachePathPrefix) {
            $path = $this->cachePathPrefix.'/'.$path;
        }

        return $path;
    }
}