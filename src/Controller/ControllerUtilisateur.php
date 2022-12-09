<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Lib\PassWord;
use Themis\Model\DataObject\Utilisateur;
use Themis\Model\Repository\UtilisateurRepository;

class ControllerUtilisateur extends AbstractController
{

    public function readAll(): void
    {
        if (!$this->isAdmin()) {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
        $utilisateurs = (new UtilisateurRepository())->selectAll();
        $this->showView("view.php", [
            "utilisateurs" => $utilisateurs,
            "pageTitle" => "Liste des utilisateurs",
            "pathBodyView" => "utilisateur/list.php"
        ]);
    }


    public function created(): void
    {
        $user = Utilisateur::buildFromForm($_GET);
        if ((new UtilisateurRepository())->select($_GET['login']) != null) {
            (new FlashMessage)->flash("mauvaisMdp", "Ce login existe déjà", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=create&controller=utilisateur");
        }
        if ($_GET["mdp"] == $_GET["mdpConfirmation"]) {
            if ($user->isAdmin() && ConnexionUtilisateur::isAdministrator()) {
                $creationCode = (new UtilisateurRepository)->create($user);
            } elseif (!$user->isAdmin()) {
                $creationCode = (new UtilisateurRepository)->create($user);
            }

            if ($creationCode == "") {
                (new FlashMessage)->flash("compteCree", "Votre compte a été créé", FlashMessage::FLASH_SUCCESS);

                $this->redirect("frontController.php?action=create&controller=utilisateur");
            } elseif ($creationCode == "23000") {
                (new FlashMessage)->flash("loginExiste", "Ce login existe déjà", FlashMessage::FLASH_DANGER);
                $this->redirect("frontController.php?action=create&controller=utilisateur");
            }
        } else {
            (new FlashMessage)->flash("mauvaisMdp", "Les mots de passes sont différents !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=create&controller=utilisateur");
        }
    }

    public function create()
    {
        $this->showView("view.php", [
            "pageTitle" => "Inscription",
            "pathBodyView" => "utilisateur/create.php"
        ]);
    }

    public function read(): void
    {
        $this->connectionCheck();
        if (ConnexionUtilisateur::isUser($_GET["login"]) || $this->isAdmin()) {
            $utilisateur = (new UtilisateurRepository)->select($_GET["login"]);
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/read.php"
            ]);
        } else $this->redirect("frontController.php?action=readAll");
    }

    public function login(): void
    {
        $this->showView("view.php", [
            "pageTitle" => "Se Connecter",
            "pathBodyView" => "utilisateur/login.php"
        ]);
    }

    public function connect(): void
    {
        if (!isset($_GET["login"]) || !isset($_GET["mdp"])) {
            (new FlashMessage)->flash("notAllInfo", "Vous n'avez pas renseigné les informations nécessaires", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=login&controller=utilisateur");
        } else if (!PassWord::check($_GET["mdp"], (new UtilisateurRepository())->select($_GET["login"])->getMdp())) {
            (new FlashMessage)->flash("badPassword", "Mot de passe incorrect", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=login&controller=utilisateur");
        } else {
            ConnexionUtilisateur::connect(($_GET["login"]));
            (new FlashMessage)->flash("badPassword", "Connection effectué", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&controller=utilisateur&login={$_GET["login"]}");
        }
    }

    public function disconnect(): void
    {
        $this->connectionCheck();
        ConnexionUtilisateur::disconnect();
        $this->redirect("frontController.php?action=readAll");
    }

    private function updatedAuxiliary()
    {
        $utilisateur = Utilisateur::buildFromForm($_GET);
        (new UtilisateurRepository)->update($utilisateur);

        $this->showView("view.php", [
            "utilisateur" => $utilisateur,
            "pageTitle" => "Info Utilisateur",
            "pathBodyView" => "utilisateur/read.php"
        ]);
    }

    public function updated(): void
    {
        $utilisateurSelect = (new UtilisateurRepository)->select($_GET["login"]);

        $this->connectionCheck();

        if (!PassWord::check($_GET["mdpAncien"], $utilisateurSelect->getMdp())) {
            (new FlashMessage)->flash("incorrectPasswd", "Le mot de passe ancien ne correspond pas", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else if ($_GET["mdp"] != $_GET["mdpConfirmation"]) {
            (new FlashMessage)->flash("incorrectPasswd", "Les mots de passes sont différents !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else if (!ConnexionUtilisateur::isUser($_GET["login"]) || !$this->isAdmin()) {
            (new FlashMessage)->flash("noAccess", "Les n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else {
            if ($this->isAdmin()) {
                if (isset($_GET['estAdmin'])) {
                    $utilisateurSelect->setEstAdmin(true);
                } else $utilisateurSelect->setEstAdmin(false);
                $this->updatedAuxiliary();
            } elseif (ConnexionUtilisateur::isUser($_GET['login'])) {
                $this->updatedAuxiliary();
            }
        }
    }

    public function update(): void
    {
        $this->connectionCheck();
        if (ConnexionUtilisateur::isUser($_GET["login"]) || $this->isAdmin()) {
            $utilisateur = (new UtilisateurRepository)->select($_GET["login"]);
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/update.php"
            ]);
        } else {
            (new FlashMessage)->flash("noAccess", "Les n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function delete(): void
    {
        if (ConnexionUtilisateur::isUser($_GET["login"])) {
            if ((new UtilisateurRepository)->delete($_GET['login'])) {
                (new FlashMessage())->flash("deleted", "Votre compte a bien été supprimé", FlashMessage::FLASH_SUCCESS);
            } else {
                (new FlashMessage())->flash("deleteFailed", "erreur de suppréssion de votre compte", FlashMessage::FLASH_DANGER);
            }
        } else {
            (new FlashMessage())->flash("notUser", "Vous n'avez pas les droits pour effectuer cette action", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=readAll");
    }
}