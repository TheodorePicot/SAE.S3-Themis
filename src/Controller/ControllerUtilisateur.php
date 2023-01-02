<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Lib\FormData;
use Themis\Lib\PassWord;
use Themis\Lib\VerificationEmail;
use Themis\Model\DataObject\Utilisateur;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\UtilisateurRepository;

class ControllerUtilisateur extends AbstractController
{

    public function readAll(): void
    {
        FormData::unsetAll();
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
        $user = Utilisateur::buildFromFormCreate($_POST);
        FormData::saveFormData("createUtilisateur");
//        VerificationEmail::sendEmailValidation($user);
        if ((new UtilisateurRepository())->select($_POST['login']) != null) {
            (new FlashMessage)->flash("mauvaisMdp", "Ce login existe déjà", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=create&controller=utilisateur&invalidLogin=1");
        }
        if ($_POST["mdp"] == $_POST["mdpConfirmation"]) {
            $creationCode = (new UtilisateurRepository)->create($user);

            if ($creationCode == "") {
                ConnexionUtilisateur::connect(($_POST["login"]));
                (new FlashMessage)->flash("compteCree", "Votre compte a été créé", FlashMessage::FLASH_SUCCESS);
                FormData::deleteFormData("createUtilisateur");
                $this->redirect("frontController.php?action=read&controller=utilisateur&login={$_POST["login"]}");
            }
        } else {
            (new FlashMessage)->flash("mauvaisMdp", "Les mots de passes sont différents !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=create&controller=utilisateur&invalidPswd=1");
        }
    }

    public function create()
    {
        FormData::deleteFormData("connection");
        $this->showView("view.php", [
            "pageTitle" => "Inscription",
            "pathBodyView" => "utilisateur/create.php"
        ]);
    }

    public function read(): void
    {
        $this->connectionCheck();
        FormData::unsetAll();
        if (ConnexionUtilisateur::isUser($_GET["login"]) || $this->isAdmin()) {
            $utilisateur = (new UtilisateurRepository)->select($_GET["login"]);
            $questions = (new QuestionRepository())->selectAllByUser($_GET["login"]);
            $propositions = (new PropositionRepository())->selectAllByUser($_GET['login']);
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "questions" => $questions,
                "propositions" => $propositions,
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
        FormData::saveFormData("connection");
        if ((new UtilisateurRepository())->select($_POST["login"]) == null) {
            (new FlashMessage)->flash("badLogin", "Ce login n'existe pas", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=login&controller=utilisateur&invalidLogin=1");
        }
        if (!isset($_POST["login"]) || !isset($_POST["mdp"])) {
            (new FlashMessage)->flash("notAllInfo", "Vous n'avez pas renseigné les informations nécessaires", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=login&controller=utilisateur");
        } else if (!PassWord::check($_POST["mdp"], (new UtilisateurRepository())->select($_POST["login"])->getMdp())) {
            (new FlashMessage)->flash("badPassword", "Mot de passe incorrect", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=login&controller=utilisateur&invalidPswd=1");
        } else {
            ConnexionUtilisateur::connect(($_POST["login"]));
            FormData::deleteFormData("loginUtilisateur");
            (new FlashMessage)->flash("connectionGood", "Connexion réussie", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&controller=utilisateur&login={$_POST["login"]}");
        }
    }

    public function disconnect(): void
    {
        $this->connectionCheck();
        FormData::unsetAll();
        ConnexionUtilisateur::disconnect();
        $this->redirect("frontController.php?action=readAll");
    }

    public function updatedForInformation(): void
    {
        $this->connectionCheck();
        if (!ConnexionUtilisateur::isUser($_POST["login"]) && !$this->isAdmin()) {
            (new FlashMessage)->flash("noAccess", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
        } else {
            $formArray = $_POST;
            unset($formArray["action"]);
            unset($formArray["controller"]);
            $formArray["estOrganisateur"] = 0;
            $formArray["estAdmin"] = 0;
            if ($this->isAdmin()) {
                if (isset($_POST["estOrganisateur"])) {
                    $formArray["estOrganisateur"] = $_POST["estOrganisateur"] == "on" ? 1 : 0;
                }
                if (isset($_POST["estAdmin"])) {
                    $formArray["estAdmin"] = $_POST["estAdmin"] == "on" ? 1 : 0;
                }
                (new UtilisateurRepository())->updateInformation($formArray);
            } elseif ($this->isOrganisateur()) {
                $formArray["estOrganisateur"] = 1;
                (new UtilisateurRepository())->updateInformation($formArray);
            } else
                (new UtilisateurRepository())->updateInformation($formArray);
            (new FlashMessage)->flash("success", "Mise à jour effectuée", FlashMessage::FLASH_SUCCESS);
        }
        $this->redirect("frontController.php?controller=utilisateur&action=read&login={$_POST["login"]}");
    }

    public function updatedForPassword()
    {
        $utilisateurSelect = (new UtilisateurRepository)->select($_POST["login"]);

        $this->connectionCheck();
        if (!PassWord::check($_POST["mdpAncien"], $utilisateurSelect->getMdp())) {
            (new FlashMessage)->flash("incorrectPasswd", "Le mot de passe ancien ne correspond pas", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=updatePassword&controller=utilisateur&login={$_POST["login"]}&invalidOld=1");
        } else if ($_POST["mdp"] != $_POST["mdpConfirmation"]) {
            (new FlashMessage)->flash("incorrectPasswd", "Les mots de passes sont différents !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=updatePassword&controller=utilisateur&login={$_POST["login"]}&invalidNew=1");
        } else if (!ConnexionUtilisateur::isUser($_POST["login"])) {
            (new FlashMessage)->flash("noAccess", "Les n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=updatePassword&controller=utilisateur&login={$_POST["login"]}");
        } else {
            $formArray = [
                "mdp" => PassWord::hash($_POST["mdp"]),
                "login" => $_POST["login"]
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
        FormData::unsetAll();
        if (ConnexionUtilisateur::isUser($_GET["login"])) {
            $utilisateur = (new UtilisateurRepository)->select($_GET["login"]);
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/updatePassword.php"
            ]);
        } else {
            (new FlashMessage)->flash("noAccess", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function delete(): void
    {
        if (ConnexionUtilisateur::isUser($_GET["login"])) {
            if ((new UtilisateurRepository)->delete($_GET['login'])) {
                $this->connectionCheck();
                ConnexionUtilisateur::disconnect();
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
            if (VerificationEmail::handleEmailValidation($login, $nonce)) {
                (new FlashMessage())->flash("success", "Votre email est valide", FlashMessage::FLASH_SUCCESS);
                $this->redirect("frontController.php?action=readAll");
            } else {
                (new FlashMessage())->flash("success", "Votre email n'est pas valide !", FlashMessage::FLASH_DANGER);
                $this->redirect("frontController.php?action=readAll");
            }
        } else {
            (new FlashMessage())->flash("success", "L'utilisateur ou le nonce n'existe pas !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    private function showUsers(array $utilisateurs)
    {
        $this->showView("view.php", [
            "utilisateurs" => $utilisateurs,
            "pageTitle" => "utilisateurs",
            "pathBodyView" => "utilisateur/list.php"
        ]);
    }

    public function readAllBySearchValue(): void
    {
        $this->showUsers((new UtilisateurRepository())->selectAllBySearchValue($_GET["searchValue"]));
    }

}