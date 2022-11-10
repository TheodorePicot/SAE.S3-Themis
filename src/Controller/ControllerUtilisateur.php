<?php

namespace Themis\Controller;

use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\UtilisateurRepository;

class ControllerUtilisateur extends AbstactController
{
    protected function getCreationMessage(): string
    {
        return "Inscription";
    }

    protected function getViewFolderName(): string
    {
        return "utilisateur";
    }

    public function created()
    {
        $utilisateur = (new UtilisateurRepository())->build($_GET);

        if ((new UtilisateurRepository())->create($utilisateur)) {
            $this->showView("view.php", [
                "pageTitle" => "Création d'une question",
                "pathBodyView" => "utilisateur/created.php"
            ]);
        } else {
            $this->showError("Ce login existe déjà");
        }
    }
}