<?php

define('TESTS_TMP_DIR', '/tmp');

$loader = require __DIR__ . '/../vendor/autoload.php';

$loader->addPsr4('AshleyDawson\\GlideBundle\\Tests\\', __DIR__);