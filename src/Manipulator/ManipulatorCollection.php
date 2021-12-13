<?php

namespace AshleyDawson\GlideBundle\Manipulator;

use AshleyDawson\GlideBundle\Exception\ManipulatorAlreadyExistsInCollectionException;
use League\Glide\Manipulators\ManipulatorInterface;

/**
 * Class ManipulatorCollection
 *
 * @package AshleyDawson\GlideBundle\Manipulator
 */
class ManipulatorCollection implements ManipulatorCollectionInterface
{
    /**
     * @var ManipulatorInterface[]
     */
    private $_manipulators = [];

    /**
     * {@inheritdoc}
     */
    public function addManipulator(ManipulatorInterface $manipulator): void
    {
        $class = get_class($manipulator);

        if (isset($this->_manipulators[$class])) {
            throw new ManipulatorAlreadyExistsInCollectionException(
                sprintf('Manipulator %s already exists in collection', $class));
        }

        $this->_manipulators[$class] = $manipulator;
    }

    /**
     * {@inheritdoc}
     */
    public function getManipulators(): array
    {
        return $this->_manipulators;
    }
}
