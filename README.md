Glide Bundle
============

[![Build Status](https://travis-ci.org/AshleyDawson/GlideBundle.svg)](https://travis-ci.org/AshleyDawson/GlideBundle)

Add [Glide](http://glide.thephpleague.com/) HTTP image processing library to Symfony projects.

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

This bundle incorporates all aspects of the Glide library within the Symfony service container - adding features and helpers
relative to working with the Glide library within Symfony projects.

Installation
------------

Make sure Composer is installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
$ composer require ashleydawson/glide-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the following command to download the latest stable
version of this bundle:

```console
$ composer require ashleydawson/glide-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles  in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    AshleyDawson\GlideBundle\AshleyDawsonGlideBundle::class => ['all' => true],
];
```

Basic Usage
-----------

The most simple example is actually using the glide server to process an image within a controller.

```php
<?php

namespace Acme\AcmeBundle\Controller;

use AshleyDawson\GlideBundle\Server\ServerFactory;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MyController extends Controller
{
    /**
     * @Route("/images/{image_name}.jpg")
     */
    public function showImageAction(Request $request, ServerFactory $serverFactory)
    {
        // Filesystems for source and cache
        $sourceFilesystem = new Filesystem(new LocalFilesystemAdapter('/path/to/source/dir'));
        $cacheFilesystem = new Filesystem(new LocalFilesystemAdapter('/path/to/cache/dir'));
    
        // Create a Glide server
        $glideServer = $serverFactory->create($sourceFilesystem, $cacheFilesystem);
        
        // Return the processed image response
        return $glideServer->getImageResponse($request->get('image_name'), $request->query->all());
    }
}
```

The example above will create a glide server using a local filesystem for the source and another for the cache. The action
then returns an image response built using the image name (in source filesystem) and request containing the manipulation
parameters.

**Note:** You may want to point the cache filesystem at the Symfony cache, `var/cache`.

Custom Manipulators
-------------------

Manipulators are services that transform an image in some way. There is a library of manipulators that ships with Glide
that provide transformations for size, effects, output, etc.

If you'd like to register your own custom manipulator, simply create one and tag it into the manipulator collection within
the Symfony service container. Like so:

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

    Acme\AcmeBundle\Glide\Manipulator\MyAwesomeManipulator:
        tags:
            - { name: ashleydawson.glide.manipulators }

```

Or, in XML:

```xml
<services>
    <service id="Acme\AcmeBundle\Glide\Manipulator\MyAwesomeManipulator">
        <tag name="ashleydawson.glide.manipulators" />
    </service>
</services>
```

Ok, now we can use this manipulator on an image:

```html
<img src="/route/to/image/controller/my-image.jpg?awesome=foo" />
```
