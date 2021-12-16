<?php

namespace AshleyDawson\GlideBundle\Tests\Manipulator;

use AshleyDawson\GlideBundle\Manipulator\ManipulatorCollection;
use League\Glide\Manipulators\ManipulatorInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ManipulatorCollectionTest
 *
 * @package AshleyDawson\GlideBundle\Tests\Manipulator
 */
class ManipulatorCollectionTest extends TestCase
{
    /**
     * @var ManipulatorCollection
     */
    private $_manipulatorCollection;

    protected function setUp(): void
    {
        $this->_manipulatorCollection = new ManipulatorCollection();
    }

    public function testInitialCollectionState(): void
    {
        $this->assertCount(0, $this->_manipulatorCollection->getManipulators());
    }

    public function testAddManipulator(): void
    {
        $this->_manipulatorCollection->addManipulator(
            $this->buildMockManipulatorInterface()
        );

        $this->assertCount(1, $this->_manipulatorCollection->getManipulators());
    }

    public function testGetMultipleManipulators(): void
    {
        $this->assertCount(0, $this->_manipulatorCollection->getManipulators());

        $this->_manipulatorCollection->addManipulator(
            $this->buildMockManipulatorInterface()
        );

        $this->assertCount(1, $this->_manipulatorCollection->getManipulators());

        $this->_manipulatorCollection->addManipulator(
            $this->buildMockManipulatorInterface()
        );

        $this->assertCount(2, $this->_manipulatorCollection->getManipulators());

        foreach ($this->_manipulatorCollection->getManipulators() as $manipulator) {
            $this->assertInstanceOf('League\Glide\Manipulators\ManipulatorInterface', $manipulator);
        }
    }

    public function testAddManipulatorAlreadyExists(): void
    {
        $this->expectException('AshleyDawson\GlideBundle\Exception\ManipulatorAlreadyExistsInCollectionException');

        $this->_manipulatorCollection->addManipulator(
            $this->buildMockManipulatorInterface('Mock_Manip')
        );

        $this->_manipulatorCollection->addManipulator(
            $this->buildMockManipulatorInterface('Mock_Manip')
        );
    }

    private function buildMockManipulatorInterface($mockClassName = null): ManipulatorInterface
    {
        return $this
            ->getMockBuilder('League\Glide\Manipulators\ManipulatorInterface')
            ->setMockClassName($mockClassName ? $mockClassName : $this->_buildRandomMockManipulatorClassName())
            ->getMock();
    }

    private function _buildRandomMockManipulatorClassName(): string
    {
        return sprintf('Mock_Manip_%s', md5(uniqid(null, true)));
    }
}
