<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Lib\PassWord;
use Themis\Lib\VerificationEmail;
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
        $utilisateurs = (new UtilisateurRepository())->selectAllOrdered();
        $this->showView("view.php", [
            "utilisateurs" => $utilisateurs,
            "pageTitle" => "Liste des utilisateurs",
            "pathBodyView" => "utilisateur/list.php"
        ]);
    }


    public function created(): void
    {
        $user = Utilisateur::buildFromFormCreate($_GET);
//        VerificationEmail::envoiEmailValidation($user);
        if ((new UtilisateurRepository())->select($_GET['login']) != null) {
            (new FlashMessage)->flash("mauvaisMdp", "Ce login existe déjà", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=create&controller=utilisateur");
        }
        if ($_GET["mdp"] == $_GET["mdpConfirmation"]) {
            $creationCode = (new UtilisateurRepository)->create($user);

            if ($creationCode == "") {
                (new FlashMessage)->flash("compteCree", "Votre compte a été créé", FlashMessage::FLASH_SUCCESS);
                $this->redirect("frontController.php?action=readAll");
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
        if ((new UtilisateurRepository())->select($_GET["login"]) == null) {
            (new FlashMessage)->flash("notAllInfo", "Ce login n'existe pas", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=login&controller=utilisateur");
        }
        if (!isset($_GET["login"]) || !isset($_GET["mdp"])) {
            (new FlashMessage)->flash("notAllInfo", "Vous n'avez pas renseigné les informations nécessaires", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=login&controller=utilisateur");
        } else if (!PassWord::check($_GET["mdp"], (new UtilisateurRepository())->select($_GET["login"])->getMdp())) {
            (new FlashMessage)->flash("badPassword", "Mot de passe incorrect", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=login&controller=utilisateur");
        } else {
            ConnexionUtilisateur::connect(($_GET["login"]));
            (new FlashMessage)->flash("badPassword", "Connexion réussie", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&controller=utilisateur&login={$_GET["login"]}");
        }
    }

    public function disconnect(): void
    {
        $this->connectionCheck();
        ConnexionUtilisateur::disconnect();
        $this->redirect("frontController.php?action=readAll");
    }

    public function updatedForInformation(): void
    {
        $utilisateurSelect = (new UtilisateurRepository)->select($_GET["login"]);

        $this->connectionCheck();

        if (!ConnexionUtilisateur::isUser($_GET["login"]) && !$this->isAdmin()) {
            (new FlashMessage)->flash("noAccess", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
        } else {
            $formArray = $_GET;
            unset($formArray["action"]);
            unset($formArray["controller"]);
            $formArray["estOrganisateur"] = 0;
            $formArray["estAdmin"] = 0;
            if ($this->isAdmin()) {
                if (isset($_GET["estOrganisateur"])) {
                    $formArray["estOrganisateur"] = $_GET["estOrganisateur"] == "on"?1:0;
                }
                if (isset($_GET["estAdmin"])) {
                    $formArray["estAdmin"] = $_GET["estAdmin"] == "on"?1:0;
                }
                (new UtilisateurRepository())->updateInformation($formArray);
            } elseif (ConnexionUtilisateur::isUser($_GET['login'])) {
                (new UtilisateurRepository())->updateInformation($formArray);
            }
            (new FlashMessage)->flash("success", "Mise à jour effectuée", FlashMessage::FLASH_SUCCESS);
        }
        $this->redirect("frontController.php?action=readAll");
    }

    public function updatedForPassword()
    {
        $utilisateurSelect = (new UtilisateurRepository)->select($_GET["login"]);

        $this->connectionCheck();
        if (!PassWord::check($_GET["mdpAncien"], $utilisateurSelect->getMdp())) {
            (new FlashMessage)->flash("incorrectPasswd", "Le mot de passe ancien ne correspond pas", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else if ($_GET["mdp"] != $_GET["mdpConfirmation"]) {
            (new FlashMessage)->flash("incorrectPasswd", "Les mots de passes sont différents !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else if (!ConnexionUtilisateur::isUser($_GET["login"])) {
            (new FlashMessage)->flash("noAccess", "Les n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else {
            $formArray = [
                "mdp" => PassWord::hash($_GET["mdp"]),
                "login" => $_GET["login"]
            ];
            (new UtilisateurRepository())->updatePassword($formArray);
            (new FlashMessage)->flash("success", "Mise à jour effectuée", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=readAll");

        }
    }

    public function updateInformation(): void
    {
        $this->connectionCheck();
        if (ConnexionUtilisateur::isUser($_GET["login"]) || $this->isAdmin()) {
            $utilisateur = (new UtilisateurRepository)->select($_GET["login"]);
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/updateInformation.php"
            ]);
        } else {
            (new FlashMessage)->flash("noAccess", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function updatePassword(): void
    {
        $this->connectionCheck();
        if (ConnexionUtilisateur::isUser($_GET["login"])) {
            $utilisateur = (new UtilisateurRepository)->select($_GET["login"]);
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/updatePassword.php"
            ]);
        }
        else {
            (new FlashMessage)->flash("noAccess", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
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

    public function validerEmail(): void
    {
        $login = $_GET['login'];
        $user = (new UtilisateurRepository())->select($login);
        if ($user != null && $user->getNonce() != "") {
            $nonce = $_GET['nonce'];
            if (VerificationEmail::traiterEmailValidation($login, $nonce)) {
                (new FlashMessage())->flash("success", "Votre email est valide", FlashMessage::FLASH_SUCCESS);
                $this->redirect("frontController.php?action=readAll");
            } else {
                //(new FlashMessage())->flash("success", "Votre email n'est pas valide !", FlashMessage::FLASH_DANGER);
                $this->redirect("frontController.php?action=readAll");
            }
        } else {
            //(new FlashMessage())->flash("success", "L'utilisateur ou le nonce n'existe pas !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

}