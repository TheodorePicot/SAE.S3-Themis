<?php
require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';
$loader = new Themis\Lib\Psr4AutoloaderClass();
$loader->addNamespace('Themis', __DIR__ . '/../src');
$loader->register();

// Verification du controller et méthodes.

use Themis\Lib\FlashMessage;
use Themis\Model\HTTP\Session;
Session::getInstance();


$controller = 'question';
if (isset($_GET['controller'])){
    $controller = $_GET['controller'];
}

$controllerClassName = "Themis\Controller\Controller" . ucfirst($controller);

$controllerClassObject = new $controllerClassName();

if (class_exists($controllerClassName)) {

    $classMethods = get_class_methods($controllerClassName);

    if (!isset($_GET['action'])) $controllerClassObject->readAll();

    elseif (in_array($_GET['action'], $classMethods)) {
        $action = $_GET['action'];
        $controllerClassObject->$action();
    } else {
        (new FlashMessage())->flash("methodeExistePas", "La méthode que vous essayez d'appeler n'existe pas", FlashMessage::FLASH_DANGER);
        header("location: frontController.php?action=readAll");
    }
} else {
    (new FlashMessage())->flash("classeExistePas", "La classe que vous essayez de charger n'existe pas", FlashMessage::FLASH_DANGER);
    header("location: frontController.php?action=readAll");
}



