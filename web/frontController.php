<?php

use Themis\Controller\ControllerVoiture;

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
$loader = new App\Covoiturage\Lib\Psr4AutoloaderClass();
$loader->addNamespace('App\Covoiturage', __DIR__ . '/../src');
$loader->register();

$action = $_GET['action'];
ControllerVoiture::$action();