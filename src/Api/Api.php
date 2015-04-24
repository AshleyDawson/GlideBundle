<?php

namespace AshleyDawson\GlideBundle\Api;

use AshleyDawson\GlideBundle\Manipulator\ManipulatorCollectionInterface;
use Intervention\Image\ImageManager;
use League\Glide\Api\Api as GlideApi;

/**
 * Class Api
 *
 * @package AshleyDawson\GlideBundle\Api
 */
class Api extends GlideApi
{
    /**
     * Constructor
     *
     * @param ImageManager $imageManager
     * @param ManipulatorCollectionInterface $manipulatorCollection
     */
    public function __construct(ImageManager $imageManager, ManipulatorCollectionInterface $manipulatorCollection)
    {
        parent::__construct(
            $imageManager,
            $manipulatorCollection->getManipulators()
        );
    }
}