<?php

namespace AshleyDawson\GlideBundle\Manipulator;

use League\Glide\Manipulators\ManipulatorInterface;

/**
 * Interface ManipulatorCollectionInterface
 *
 * @package AshleyDawson\GlideBundle\Manipulator
 */
interface ManipulatorCollectionInterface
{
    /**
     * Add a manipulator to the collection
     *
     * @param ManipulatorInterface $manipulator
     * @return void
     * @throws \AshleyDawson\GlideBundle\Exception\ManipulatorAlreadyExistsInCollectionException
     */
    public function addManipulator(ManipulatorInterface $manipulator): void;

    /**
     * Get the collection of manipulators as an array
     *
     * @return ManipulatorInterface[]
     */
    public function getManipulators(): array;
}
