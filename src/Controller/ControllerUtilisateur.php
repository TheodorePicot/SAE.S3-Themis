<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Lib\PassWord;
use Themis\Model\DataObject\Participant;
use Themis\Model\DataObject\Utilisateur;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\UtilisateurRepository;
use Themis\Model\Repository\VotantRepository;

class ControllerUtilisateur extends AbstractController
{

    public function readAll(): void {
        $utilisateurs = (new UtilisateurRepository())->selectAll();
        if (ConnexionUtilisateur::isAdministrator()){
            $this->showView("view.php", [
                "utilisateurs" => $utilisateurs,
                "pageTitle" => "Liste des utilisateurs",
                "pathBodyView" => "utilisateur/list.php"
            ]);
        }
    }


    public function created(): void
    {
        $user = Utilisateur::buildFromForm($_GET);
        if ((new UtilisateurRepository())->select($_GET['login']) != null) {
            (new FlashMessage)->flash("mauvaisMdp", "Ce login existe déjà", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=create&controller=utilisateur");
        }
        if ($_GET["mdp"] == $_GET["mdpConfirmation"]) {
            if($user->isEstAdmin() && ConnexionUtilisateur::isAdministrator()){
                $creationCode = (new UtilisateurRepository)->create($user);
            }
            elseif (!$user->isEstAdmin()){
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

    public function createParticipants(int $idQuestion)
    {
        foreach ($_GET["votants"] as $votant) {
            $votantObject = new Participant($votant, $idQuestion);
            (new VotantRepository)->create($votantObject);
        }

        foreach ($_GET["auteurs"] as $auteur) {
            $auteurObject = new Participant($auteur, $idQuestion);
            (new AuteurRepository)->create($auteurObject);
        }
    }

    public function read(): void
    {
        if (ConnexionUtilisateur::isUser($_GET["login"]) || ConnexionUtilisateur::isAdministrator()) {
            $utilisateur = (new UtilisateurRepository)->select($_GET["login"]);
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/read.php"
            ]);
        }
        else $this->redirect("frontController.php?action=readAll");
        //todo garder la redirection vers readAll mais avec un message flash type danger

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
        ConnexionUtilisateur::disconnect();
        $this->redirect("frontController.php?action=readAll");
        // TODO popup
    }

    public function updated(): void
    {
        $utilisateurSelect = (new UtilisateurRepository)->select($_GET["login"]);

        if (!PassWord::check($_GET["mdpAncien"], $utilisateurSelect->getMdp())) {
            (new FlashMessage)->flash("incorrectPasswd", "Le mot de passe ancien ne correspond pas", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else if ($_GET["mdp"] != $_GET["mdpConfirmation"]) {
            (new FlashMessage)->flash("incorrectPasswd", "Les mots de passes sont différents !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else if (!ConnexionUtilisateur::isUser($_GET["login"]) && !ConnexionUtilisateur::isAdministrator()) {
            // todo message flash
            $this->redirect("frontController.php?action=update&controller=utilisateur&login={$_GET["login"]}");
        } else {
            if (ConnexionUtilisateur::isAdministrator()){
                if(isset($_GET['estAdmin'])){
                    $utilisateurSelect->setEstAdmin(true);
                }
                else $utilisateurSelect->setEstAdmin(false);
                $utilisateur = Utilisateur::buildFromForm($_GET);
                (new UtilisateurRepository)->update($utilisateur);

                $this->showView("view.php", [
                    "utilisateur" => $utilisateur,
                    "pageTitle" => "Info Utilisateur",
                    "pathBodyView" => "utilisateur/read.php"
                ]);
            }
            elseif (ConnexionUtilisateur::isUser($_GET['login'])){
                $utilisateur = Utilisateur::buildFromForm($_GET);
                (new UtilisateurRepository)->update($utilisateur);

                $this->showView("view.php", [
                    "utilisateur" => $utilisateur,
                    "pageTitle" => "Info Utilisateur",
                    "pathBodyView" => "utilisateur/read.php"
                ]);
            }
        }
    }

    public function update(): void
    {
        $utilisateur = (new UtilisateurRepository)->select($_GET["login"]);
        if (ConnexionUtilisateur::isUser($_GET["login"]) || ConnexionUtilisateur::isAdministrator())
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/update.php"
            ]);
        else $this->redirect("frontController.php?action=readAll");
        //todo garder la redirection vers readAll mais avec un message flash type danger
    }

    public function deleteParticipants(int $idQuestion)
    {
        (new VotantRepository)->delete($idQuestion);
        (new AuteurRepository)->delete($idQuestion);
    }

    public function delete(): void
    {
        if (ConnexionUtilisateur::isUser($_GET["login"])){
            if ((new UtilisateurRepository)->delete($_GET['login'])) {
                (new FlashMessage())->flash("deleted", "Votre compte a bien été supprimé", FlashMessage::FLASH_SUCCESS);
            } else {
                (new FlashMessage())->flash("deleteFailed", "erreur de suppréssion de votre compte", FlashMessage::FLASH_DANGER);
            }
        }
        else {
            (new FlashMessage())->flash("notUser", "Vous n'avez pas les droits pour effectuer cette action", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=readAll");
        //todo garder la redirection vers readAll mais avec un message flash type danger

    }
}