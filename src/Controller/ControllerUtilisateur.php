<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Lib\MotDePasse;
use Themis\Model\DataObject\Utilisateur;
use Themis\Model\HTTP\Session;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\UtilisateurRepository;

class ControllerUtilisateur extends AbstactController
{
    public function create()
    {
        $this->showView("view.php", [
            "pageTitle" => "Inscription",
            "pathBodyView" => "utilisateur/create.php"
        ]);
    }

    public function created(): void
    {
        if ($_GET['mdp'] == $_GET['mdp2']) {
            $utilisateur = Utilisateur::buildFromForm($_GET);

            if ((new UtilisateurRepository)->create($utilisateur)) {
                $this->showView("view.php", [
                    "pageTitle" => "Création d'une utilisateur",
                    "pathBodyView" => "utilisateur/created.php"
                ]);
            } else {
                $this->showError("Ce login existe déjà");
            }
        } else {
            (new FlashMessage)->flash("mauvaisMdp", "Les mots de passes sont différents !", FlashMessage::FLASH_ERROR);
            header("location: frontController.php?action=create&controller=utilisateur");
        }

    }

    public function read(): void
    {
        $utilisateur = (new UtilisateurRepository)->select($_GET['login']);

        $this->showView("view.php", [
            "utilisateur" => $utilisateur,
            "pageTitle" => "Info Utilisateur",
            "pathBodyView" => "utilisateur/read.php"
        ]);
    }

    public function login(): void
    {
        $this->showView("view.php", [
            "pageTitle" => "Se Connecter",
            "pathBodyView" => "utilisateur/login.php"
        ]);
    }

    public function connecter(): void
    {
        if (!isset($_GET['login']) || !isset($_GET['mdp'])) self::login();
        $utilisateurSelect = (new UtilisateurRepository())->select($_GET['login']);
        if (!MotDePasse::check($_GET['mdp'], $utilisateurSelect->getMdp())) {
            self::login();
        } else {
            ConnexionUtilisateur::connecter(($_GET['login']));
            self::read();
        }
    }

    public function deconnecter(): void
    {
        ConnexionUtilisateur::deconnecter();
        header("location:frontController.php?action=readAll");
    }


    public function update(): void
    {
        $utilisateur = (new UtilisateurRepository)->select($_GET['login']);

        $this->showView("view.php", [
            "utilisateur" => $utilisateur,
            "pageTitle" => "Info Utilisateur",
            "pathBodyView" => "utilisateur/update.php"
        ]);
    }

    public function updated(): void
    {
        $utilisateurSelect = (new UtilisateurRepository)->select($_GET['login']);

        if ($_GET['mdp'] == $_GET['mdp2'] && MotDePasse::check($_GET['mdpAncien'], $utilisateurSelect->getMdp())) {
            $utilisateur = Utilisateur::buildFromForm($_GET);
            (new UtilisateurRepository)->update($utilisateur);

            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/read.php"
            ]);
        } else {
            //flash Théodore
            self::update();
        }


    }

    public function delete(): void
    {
        if ((new UtilisateurRepository)->delete($_GET['login'])) {
            $questions = (new QuestionRepository)->selectAll();
            $this->showView("view.php", [
                "questions" => $questions,
                "pageTitle" => "Suppression",
                "pathBodyView" => "utilisateur/deleted.php"
            ]);
        }
    }


}