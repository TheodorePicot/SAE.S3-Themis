<?php

namespace Themis\Controller;

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
                "pageTitle" => "Création d'une utilisateur",
                "pathBodyView" => "utilisateur/created.php"
            ]);
        } else {
            $this->showError("Ce login existe déjà");
        }
    }

    public function read()
    {
        $utilisateur = (new UtilisateurRepository)->select($_GET['login']);

        $this->showView("view.php", [
            "utilisateur" => $utilisateur,
            "pageTitle" => "Info Utilisateur",
            "pathBodyView" => "utilisateur/read.php"
        ]);
    }

    public function update()
    {
        $utilisateur = (new UtilisateurRepository)->select($_GET['login']);

        $this->showView("view.php", [
            "utilisateur" => $utilisateur,
            "pageTitle" => "Info Utilisateur",
            "pathBodyView" => "utilisateur/update.php"
        ]);
    }

    public function updated()
    {
        $utilisateur = (new UtilisateurRepository)->build($_GET);
        (new UtilisateurRepository)->update($utilisateur);

        $this->showView("view.php", [
            "utilisateur" => $utilisateur,
            "pageTitle" => "Info Utilisateur",
            "pathBodyView" => "utilisateur/read.php"
        ]);
    }
}