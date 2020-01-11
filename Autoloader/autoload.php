<?php

namespace Rocky114\Excel\Autoloader;

require_once 'Psr4Autoloader.php';

/**
 * @var string
 * Full path to "src/Spout" which is what we want "Box\Spout" to map to.
 */
$srcBaseDirectory = \dirname(\dirname(__FILE__));

$loader = new Psr4Autoloader();
$loader->register();
$loader->addNamespace('Rocky114\Excel', $srcBaseDirectory);
