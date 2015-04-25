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
            $path = $filter($path, $this->getCache());
        }

        if ($this->cachePathPrefix) {
            $path = $this->cachePathPrefix.'/'.$path;
        }

        return $path;
    }
}