Glide Bundle
============

[![Build Status](https://travis-ci.org/AshleyDawson/GlideBundle.svg)](https://travis-ci.org/AshleyDawson/GlideBundle)

[![knpbundles.com](http://knpbundles.com/AshleyDawson/GlideBundle/badge-short)](http://knpbundles.com/AshleyDawson/GlideBundle)

Add [Glide](http://glide.thephpleague.com/) HTTP image processing library to Symfony 2 projects.

Introduction
------------

[Glide](http://glide.thephpleague.com/) is an image processing/manipulation/cache for images. It's particularly handy for
modifying and storing images on [Flysystem](https://github.com/thephpleague/flysystem) filesystems. It leverages the 
[Intervention](http://image.intervention.io/) image manager to do the heavy lifting. The image API is exposed via an HTTP 
interface allowing you to embed images within your application. For example:

```html
<!-- Embed version of a particular image, truncating the width to 300 pixels -->
<img src="/route/to/image/controller/my-image.jpg?w=300" />
```

For more information and a better explanation, please read the [official Glide docs](http://glide.thephpleague.com/).

This bundle incorporates all aspects of the Glide library within the Symfony 2 service container - adding features and helpers
relative to working with the Glide library within Symfony 2 projects.

Installation
------------

You can install the Glide Bundle via Composer. To do that, simply require the package in your composer.json file like so:

```json
{
    "require": {
        "ashleydawson/glide-bundle": "~1.0"
    }
}
```

Run composer update to install the package. Then you'll need to register the bundle in your `app/AppKernel.php`:

```php
$bundles = array(
    // ...
    new AshleyDawson\GlideBundle\AshleyDawsonGlideBundle(),
);
```

Basic Usage
-----------

The most simple example is actually using the glide server to process an image within a controller.

```php
<?php

namespace Acme\AcmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;

class MyController extends Controller
{
    /**
     * @Route("/images/{image_name}.jpg")
     */
    public function showImageAction(Request $request)
    {
        // Filesystems for source and cache
        $sourceFilesystem = new Filesystem(new Local('/path/to/source/dir'));
        $cacheFilesystem = new Filesystem(new Local('/path/to/cache/dir'));
    
        // Create a Glide server
        $glideServer = $this
            ->get('ashleydawson.glide.server_factory')
            ->create($sourceFilesystem, $cacheFilesystem)
        ;
        
        // Return the processed image response
        return $glideServer->getImageResponse($request->get('image_name'), $request);
    }
}
```

The example above will create a glide server using a local filesystem for the source and another for the cache. The action
then returns an image response built using the image name (in source filesystem) and request containing the manipulation
parameters.

**Note:** You may want to point the cache filesystem at the Symfony cache, `app/cache`.

Custom Manipulators
-------------------

Manipulators are services that transform an image in some way. There is a library of manipulators that ships with Glide
that provide transformations for size, effects, output, etc.

If you'd like to register your own custom manipulator, simply create one and tag it into the manipulator collection within
the Symfony 2 service container. Like so:

```php
<?php

namespace Acme\AcmeBundle\Glide\Manipulator;

use League\Glide\Api\Manipulator\ManipulatorInterface;
use Intervention\Image\Image;
use Symfony\Component\HttpFoundation\Request;

class MyAwesomeManipulator implements ManipulatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function run(Request $request, Image $image)
    {
        if ($request->has('awesome')) {
            // Do something awesome to the image here...    
        }
    
        return $image;
    }
}
```

Then, in the service container, simply tag your new manipulator as being a part of the glide manipulators collection.

In YAML:

```yml

services:

    acme.glide.manipulator.my_awesome_manipulator:
        class: Acme\AcmeBundle\Glide\Manipulator\MyAwesomeManipulator
        tags:
            - { name: ashleydawson.glide.manipulators }

```

Or, in XML:

```xml
<services>
    <service id="acme.glide.manipulator.my_awesome_manipulator" class="Acme\AcmeBundle\Glide\Manipulator\MyAwesomeManipulator">
        <tag name="ashleydawson.glide.manipulators" />
    </service>
</services>
```

Ok, now we can use this manipulator on an image:

```html
<img src="/route/to/image/controller/my-image.jpg?awesome=foo" />
```
