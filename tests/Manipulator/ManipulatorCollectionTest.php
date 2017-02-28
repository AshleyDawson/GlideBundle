<?php

namespace AshleyDawson\GlideBundle\Tests\Manipulator;

use AshleyDawson\GlideBundle\Manipulator\ManipulatorCollection;

/**
 * Class ManipulatorCollectionTest
 *
 * @package AshleyDawson\GlideBundle\Tests\Manipulator
 */
class ManipulatorCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ManipulatorCollection
     */
    private $_manipulatorCollection;

    protected function setUp()
    {
        $this->_manipulatorCollection = new ManipulatorCollection();
    }

    public function testInitialCollectionState()
    {
        $this->assertCount(0, $this->_manipulatorCollection->getManipulators());
    }

    public function testAddManipulator()
    {
        $this->_manipulatorCollection->addManipulator(
            $this->getMock('League\Glide\Manipulators\ManipulatorInterface', [], [], $this->_buildRandomMockManipulatorClassName())
        );

        $this->assertCount(1, $this->_manipulatorCollection->getManipulators());
    }

    public function testGetMultipleManipulators()
    {
        $this->assertCount(0, $this->_manipulatorCollection->getManipulators());

        $this->_manipulatorCollection->addManipulator(
            $this->getMock('League\Glide\Manipulators\ManipulatorInterface', [], [], $this->_buildRandomMockManipulatorClassName())
        );

        $this->assertCount(1, $this->_manipulatorCollection->getManipulators());

        $this->_manipulatorCollection->addManipulator(
            $this->getMock('League\Glide\Manipulators\ManipulatorInterface', [], [], $this->_buildRandomMockManipulatorClassName())
        );

        $this->assertCount(2, $this->_manipulatorCollection->getManipulators());

        foreach ($this->_manipulatorCollection->getManipulators() as $manipulator) {
            $this->assertInstanceOf('League\Glide\Manipulators\ManipulatorInterface', $manipulator);
        }
    }

    public function testAddManipulatorAlreadyExists()
    {
        $this->setExpectedException('AshleyDawson\GlideBundle\Exception\ManipulatorAlreadyExistsInCollectionException');

        $this->_manipulatorCollection->addManipulator(
            $this->getMock('League\Glide\Manipulators\ManipulatorInterface', [], [], 'Mock_Manip')
        );

        $this->_manipulatorCollection->addManipulator(
            $this->getMock('League\Glide\Manipulators\ManipulatorInterface', [], [], 'Mock_Manip')
        );
    }

    private function _buildRandomMockManipulatorClassName()
    {
        return sprintf('Mock_Manip_%s', md5(uniqid(null, true)));
    }
}