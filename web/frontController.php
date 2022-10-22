<?php

// Chargement du PSR4AutoLoader
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
$loader = new Themis\Lib\Psr4AutoloaderClass();
$loader->addNamespace('Themis', __DIR__ . '/../src');
$loader->register();

// Verification du controller et méthodes.

use Themis\Controller\AbstactController;

$controller = 'question';
if (isset($_GET['controller'])) $controller = $_GET['controller'];

$controllerClassName = "Themis\Controller\Controller" . ucfirst($controller);

if (class_exists($controllerClassName)) {

    $classMethods = get_class_methods($controllerClassName);

    if (!isset($_GET['action'])) $controllerClassName::readAll();

    elseif (in_array($_GET['action'], $classMethods)) {
        $action = $_GET['action'];
        $controllerClassName::$action();
    } else {
        AbstactController::showError("La méthode que vous essayez d'appeler n'existe pas");
    }
} else AbstactController::showError("La classe que vous essayez de charger n'existe pas");

