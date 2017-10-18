<?php

namespace AshleyDawson\GlideBundle\Tests\Server;

use AshleyDawson\GlideBundle\Server\ServerFactory;
use Intervention\Image\ImageManager;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Glide\Api\Api;

/**
 * Class ServerFactoryTest
 *
 * @package AshleyDawson\GlideBundle\Tests\Server
 */
class ServerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ServerFactory
     */
    private $_serverFactory;

    protected function setUp()
    {
        $api = new Api(
            new ImageManager([
                'driver' => 'gd',
            ]), [
                new \League\Glide\Manipulators\Orientation(),
                new \League\Glide\Manipulators\Crop(),
                new \League\Glide\Manipulators\Size(2000*2000),
                new \League\Glide\Manipulators\Brightness(),
                new \League\Glide\Manipulators\Contrast(),
                new \League\Glide\Manipulators\Gamma(),
                new \League\Glide\Manipulators\Sharpen(),
                new \League\Glide\Manipulators\Filter(),
                new \League\Glide\Manipulators\Blur(),
                new \League\Glide\Manipulators\Pixelate(),
                new \League\Glide\Manipulators\Watermark(),
                new \League\Glide\Manipulators\Background(),
                new \League\Glide\Manipulators\Border(),
                new \League\Glide\Manipulators\Encode(),
            ]
        );

        $this->_serverFactory = new ServerFactory($api);
    }

    public function testCreateServer()
    {
        $source = $this->_getLocalFilesystem('/source');
        $cache = $this->_getLocalFilesystem('/cache');

        $server = $this->_serverFactory->create($source, $cache);

        $this->assertInstanceOf('League\Glide\Server', $server);
    }

    private function _getLocalFilesystem($prefix = '')
    {
        return new Filesystem(new Local(TESTS_TMP_DIR . $prefix));
    }
}