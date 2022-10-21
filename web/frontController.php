<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
$loader = new Themis\Lib\Psr4AutoloaderClass();
$loader->addNamespace('Themis', __DIR__ . '/../src');
$loader->register();

