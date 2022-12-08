<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;

abstract class AbstractController
{
    protected function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }

    protected function connectionCheck() {
        if (!ConnexionUtilisateur::isConnected()) {
            (new FlashMessage())->flash("notConnected", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }
}