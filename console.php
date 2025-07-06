<?php

declare(strict_types=1);

use NeufferTest\Autoloader;

// Bootstrap the application
require_once __DIR__ . '/src/Autoloader.php';

$autoloader = new Autoloader();
$autoloader->addNamespace('NeufferTest', __DIR__ . '/src');
$autoloader->register();

use NeufferTest\Application;

// Get command line options
$shortopts = "a:f:";
$longopts = [
    "action:",
    "file:",
];

$options = getopt($shortopts, $longopts);

// Create and run the application
$app = new Application();
$app->run($options);
