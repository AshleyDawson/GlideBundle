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
                new \League\Glide\Api\Manipulator\Orientation(),
                new \League\Glide\Api\Manipulator\Rectangle(),
                new \League\Glide\Api\Manipulator\Size(2000*2000),
                new \League\Glide\Api\Manipulator\Brightness(),
                new \League\Glide\Api\Manipulator\Contrast(),
                new \League\Glide\Api\Manipulator\Gamma(),
                new \League\Glide\Api\Manipulator\Sharpen(),
                new \League\Glide\Api\Manipulator\Filter(),
                new \League\Glide\Api\Manipulator\Blur(),
                new \League\Glide\Api\Manipulator\Pixelate(),
                new \League\Glide\Api\Manipulator\Output(),
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