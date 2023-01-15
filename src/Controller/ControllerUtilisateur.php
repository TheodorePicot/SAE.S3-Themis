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

    /**
     * Permet d'afficher tous les utilisateurs
     * Cette méthode est réservée uniquement aux administrateurs.
     * Elle vérifie si l'utilisateur actuellement connecté est bien admin.
     * Si oui elle le redirige vers la bonne vue.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     *
     * La méthode de la première ligne permet d'effacer toutes données stocker dans {@link $_SESSION} par rapport au
     * refresh des formulaires lors de l'incohérence des dates pour la création d'une question.
     *
     * @return void
     * @see FormData::unsetAll();
     *
     */
    public function readAll(): void
    {

        FormData::unsetAll();
        $this->connectionCheck();
        if (!$this->isAdmin()) {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
        $organisateurs = (new UtilisateurRepository())->selectAllOrderedOrganisateurWithLimit();

        $utilisateurs = (new UtilisateurRepository())->selectAllOrderedUtilisateurWithLimit();

        $administrateurs = (new UtilisateurRepository())->selectAllOrderedAdminWithLimit();

        $this->showView("view.php", [
            "organisateurs" => $organisateurs,
            "administrateurs" => $administrateurs,
            "utilisateurs" => $utilisateurs,
            "pageTitle" => "Liste des utilisateurs",
            "pathBodyView" => "utilisateur/list.php"
        ]);
    }


    /**
     * Permet de créer un compte.
     *
     * Cette méthode créée un {@link Utilisateur}
     *
     * @return void
     */
    public function created(): void
    {

        $user = Utilisateur::buildFromFormCreate($_REQUEST);
        FormData::saveFormData("createUtilisateur");
        VerificationEmail::sendEmailValidation($user);
        if ((new UtilisateurRepository())->select($_REQUEST['login']) != null) {
            (new FlashMessage)->flash("mauvaisMdp", "Ce login existe déjà", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=create&controller=utilisateur&invalidLogin=1");
        }
        if ($_REQUEST["mdp"] == $_REQUEST["mdpConfirmation"]) {
            $creationCode = (new UtilisateurRepository)->create($user);

            if ($creationCode == "" && ConnexionUtilisateur::isAdministrator()) {
                (new FlashMessage)->flash("compteCree", "Le compte a bien été crée", FlashMessage::FLASH_INFO);
                FormData::deleteFormData("createUtilisateur");
                $this->redirect("frontController.php?action=readAll&controller=utilisateur");
            }
            if ($creationCode == "" && !ConnexionUtilisateur::isAdministrator()) {
                ConnexionUtilisateur::connect(($_REQUEST["login"]));
                (new FlashMessage)->flash("compteCree", "Votre compte a été créé, veuillez valider votre email", FlashMessage::FLASH_INFO);
                FormData::deleteFormData("createUtilisateur");
                $this->redirect("frontController.php?action=readAll");
            }
        } else {
            (new FlashMessage)->flash("mauvaisMdp", "Les mots de passes sont différents !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=create&controller=utilisateur&invalidPswd=1");
        }
    }

    /**
     * Permet de rediriger l'utilisateur vers la vue {@link src/View/utilisateur/create.php} pour qu'il puisse créer son compte
     *
     * @return void
     */
    public function create(): void
    {
        FormData::deleteFormData("connection");
        $this->showView("view.php", [
            "pageTitle" => "Inscription",
            "pathBodyView" => "utilisateur/create.php"
        ]);
    }

    /**
     * Permet de lire le compte de l'utilisateur sélectionnée.
     *
     * Cette méthode charge les données nécessaires puis fait appelle à {@link AbstractController::showView()}
     * pour afficher la vue {@link src/View/utilisateur/read.php}.
     *
     * @return void
     */
    public function read(): void
    {
        $this->connectionCheck();
        FormData::unsetAll();
        if (ConnexionUtilisateur::isUser($_REQUEST["login"]) || $this->isAdmin()) {
            $utilisateur = (new UtilisateurRepository)->select($_REQUEST["login"]);
            $questions = (new QuestionRepository())->selectAllByUser($_REQUEST["login"]);
            $propositions = (new PropositionRepository())->selectAllByUser($_REQUEST['login']);
            $this->showView("view.php", [
                "utilisateur" => $utilisateur,
                "questions" => $questions,
                "propositions" => $propositions,
                "pageTitle" => "Info Utilisateur",
                "pathBodyView" => "utilisateur/read.php"
            ]);
        } else $this->redirect("frontController.php?action=readAll");
    }

    /**
     * Permet de rediriger l'utilisateur vers la vue {@link src/View/utilisateur/login.php} pour qu'il puisse se connecter
     *
     * @return void
     */
    public function login(): void
    {
        $this->showView("view.php", [
            "pageTitle" => "Se Connecter",
            "pathBodyView" => "utilisateur/login.php"
        ]);
    }

    /**
     * Connecte l'utilisateur par rapport aux informations du formulaire
     *
     * Cette méthode est appelée quand un utilisateur soumet les informations du formulaire dans {@link src/View/utilisateur/login.php}
     * Elle vérifie si le login et le mot de passe transmi existent dans la base de donnée. Puis elle vérifie que l'utilisateur transmet bien un login et
     * un mot de passe.
     * Si toutes ces vérifications sont validées, elle connecte l'utilisateur.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     * La méthode {@link FormData::saveFormData()} permet de stocker toutes les données dans {@link $_SESSION} par rapport au
     * refresh des formulaires lors de l'incohérence des dates. Si nous ne faisons pas cela les informations données dans le formulaire serait perdues
     * lors de la redirection.
     *
     * @return void
     */
    public function connect(): void
    {
        FormData::saveFormData("connection");
        if ((new UtilisateurRepository())->select($_REQUEST["login"]) == null) {
            (new FlashMessage)->flash("badLogin", "Ce login n'existe pas", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=login&controller=utilisateur&invalidLogin=1");
        }
        if (!VerificationEmail::hasValidatedEmail((new UtilisateurRepository())->select($_REQUEST["login"]))) {
            (new FlashMessage)->flash("invalidMail", "Veuillez valider votre email avant de vous connecter", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=login&controller=utilisateur");
        }
        if (!isset($_REQUEST["login"]) || !isset($_REQUEST["mdp"])) {
            (new FlashMessage)->flash("notAllInfo", "Vous n'avez pas rempli toutes les informations nécessaires", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=login&controller=utilisateur");
        } else if (!PassWord::check($_REQUEST["mdp"], (new UtilisateurRepository())->select($_REQUEST["login"])->getMdp())) {
            (new FlashMessage)->flash("badPassword", "Mot de passe incorrect", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=login&controller=utilisateur&invalidPswd=1");
        } else {
            ConnexionUtilisateur::connect(($_REQUEST["login"]));
            FormData::deleteFormData("loginUtilisateur");
            (new FlashMessage)->flash("connectionGood", "Connexion réussie", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Permet de déconnecter l'utilisateur actuellement connecté.
     *
     * Supprime toutes les données de formulaire puis déconnecte l'utilisateur.
     *
     * @return void
     */
    public function disconnect(): void
    {
        $this->connectionCheck();
        FormData::unsetAll();
        ConnexionUtilisateur::disconnect();
        $this->redirect("frontController.php?action=readAll");
    }

    /**
     * Permet de mettre à jour les informations de son compte. Mais pas le mot de passe.
     *
     * Cette méthode fait des vérifications de sécurité puis met à jour les informations de l'utilisateur.
     *
     * @return void
     */
    public function updatedForInformation(): void
    {
        $this->connectionCheck();
        if (!ConnexionUtilisateur::isUser($_REQUEST["login"]) && !$this->isAdmin()) {
            (new FlashMessage)->flash("noAccess", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
        } else {
            $formArray = $_REQUEST;
            unset($formArray["action"]);
            unset($formArray["controller"]);
            $formArray["estOrganisateur"] = 0;
            $formArray["estAdmin"] = 0;
            if ($this->isAdmin()) {
                if (isset($_REQUEST["estOrganisateur"])) {
                    $formArray["estOrganisateur"] = $_REQUEST["estOrganisateur"] == "on" ? 1 : 0;
                }
                if (isset($_REQUEST["estAdmin"])) {
                    $formArray["estAdmin"] = $_REQUEST["estAdmin"] == "on" ? 1 : 0;
                }
                (new UtilisateurRepository())->updateInformation($formArray);
            } elseif ($this->isOrganisateur()) {
                $formArray["estOrganisateur"] = 1;
                (new UtilisateurRepository())->updateInformation($formArray);
            } else
                (new UtilisateurRepository())->updateInformation($formArray);
            (new FlashMessage)->flash("success", "Mise à jour effectuée", FlashMessage::FLASH_SUCCESS);
        }
        $this->redirect("frontController.php?controller=utilisateur&action=read&login={$_REQUEST["login"]}");
    }

    /**
     * Permet uniquement de mettre à jour le mot de passe de son compte.
     *
     * Cette méthode fait des vérifications de sécurité puis met à jour le mot de passe de l'utilisateur.
     *
     * @return void
     */
    public function updatedForPassword(): void
    {
        $utilisateurSelect = (new UtilisateurRepository)->select($_REQUEST["login"]);

        $this->connectionCheck();
        if (!PassWord::check($_REQUEST["mdpAncien"], $utilisateurSelect->getMdp())) { // si son mot de passe actuel n'est pas égal au mot de passe qu'il a rentré (verifier si c'est bien l'utilisateur)
            (new FlashMessage)->flash("incorrectPasswd", "Le mot de passe ancien ne correspond pas", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=updatePassword&controller=utilisateur&login={$_REQUEST["login"]}&invalidOld=1");
        } else if ($_REQUEST["mdp"] != $_REQUEST["mdpConfirmation"]) {
            (new FlashMessage)->flash("incorrectPasswd", "Les mots de passes sont différents !", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=updatePassword&controller=utilisateur&login={$_REQUEST["login"]}&invalidNew=1");
        } else if (!ConnexionUtilisateur::isUser($_REQUEST["login"])) {
            (new FlashMessage)->flash("noAccess", "Les n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=updatePassword&controller=utilisateur&login={$_REQUEST["login"]}");
        } else {
            $formArray = [
                "mdp" => PassWord::hash($_REQUEST["mdp"]),
                "login" => $_REQUEST["login"]
            ];
            (new UtilisateurRepository())->updatePassword($formArray);
            (new FlashMessage)->flash("success", "Mise à jour effectuée", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Affiche la vue permettant de mettre à jour ces informations
     *
     * @return void
     */
    public function updateInformation(): void
    {
        $this->connectionCheck();
        if (ConnexionUtilisateur::isUser($_REQUEST["login"]) || $this->isAdmin()) {
            $utilisateur = (new UtilisateurRepository)->select($_REQUEST["login"]);
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

    /**
     * Affiche la vue permettant de mettre à jour son mot de passe
     *
     * @return void
     */
    public function updatePassword(): void
    {
        $this->connectionCheck();
        FormData::unsetAll();
        if (ConnexionUtilisateur::isUser($_REQUEST["login"])) {
            $utilisateur = (new UtilisateurRepository)->select($_REQUEST["login"]);
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

    /**
     * Permet de supprimer un utilisateur
     *
     * Fait des vérifications de sécurité et supprime si tout est bon
     *
     * @return void
     */
    public function delete(): void
    {


        if (ConnexionUtilisateur::isUser($_REQUEST["login"]) && !ConnexionUtilisateur::isAdministrator()) {
            if ((new UtilisateurRepository)->delete($_REQUEST['login'])) {
                $this->connectionCheck();
                ConnexionUtilisateur::disconnect();
                (new FlashMessage())->flash("deleted", "Votre compte a bien été supprimé", FlashMessage::FLASH_SUCCESS);
            } else {
                (new FlashMessage())->flash("deleteFailed", "La suppression a échouée", FlashMessage::FLASH_DANGER);
            }
        } else if (ConnexionUtilisateur::isAdministrator()) {
            $user = (new UtilisateurRepository())->select($_REQUEST['login']);
            if ($user->isAdmin()) {
                (new FlashMessage())->flash("notUser", "Vous n'avez pas les droits pour effectuer cette action", FlashMessage::FLASH_DANGER);
            } else {
                if ((new UtilisateurRepository)->delete($_REQUEST['login'])) {
                    $this->connectionCheck();
                    (new FlashMessage())->flash("deleted", "Le compte a bien été supprimé", FlashMessage::FLASH_SUCCESS);
                }
            }

        }
        $this->redirect("frontController.php?action=readAll");
    }

    /**
     * Méthode permettant de valider l'email d'un utilisateur
     *
     * Regarde si l'utilisateur donné existe bien et que le nonce de l'utilisateur est valide
     *
     * @return void
     */
    public function validerEmail(): void
    {
        $login = $_REQUEST['login'];
        $user = (new UtilisateurRepository())->select($login);
        if ($user != null && $user->getNonce() != "") {
            $nonce = $_REQUEST['nonce'];
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

    /**
     *
     *
     * @return void
     */
    public function readAllAdminBySearchValue(): void
    {
        if (!$this->isAdmin()) {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
        $administrateurs = (new UtilisateurRepository())->selectAllAdminBySearchValue($_REQUEST["searchValue"]);
        $organisateurs = (new UtilisateurRepository())->selectAllOrderedOrganisateurWithLimit();
        $utilisateurs = (new UtilisateurRepository())->selectAllOrderedUtilisateurWithLimit();

        $this->showView("view.php", [
            "organisateurs" => $organisateurs,
            "utilisateurs" => $utilisateurs,
            "administrateurs" => $administrateurs,
            "pageTitle" => "utilisateurs",
            "pathBodyView" => "utilisateur/list.php"
        ]);
    }

    public function readAllOrganisateurBySearchValue(): void
    {
        if (!$this->isAdmin()) {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
        $administrateurs = (new UtilisateurRepository())->selectAllOrderedAdminWithLimit();
        $organisateurs = (new UtilisateurRepository())->selectAllOrganisateurBySearchValue($_REQUEST["searchValue"]);
        $utilisateurs = (new UtilisateurRepository())->selectAllOrderedUtilisateurWithLimit();

        $this->showView("view.php", [
            "organisateurs" => $organisateurs,
            "utilisateurs" => $utilisateurs,
            "administrateurs" => $administrateurs,
            "pageTitle" => "utilisateurs",
            "pathBodyView" => "utilisateur/list.php"
        ]);
    }

    public function readAllUtilisateurBySearchValue(): void
    {
        if (!$this->isAdmin()) {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
        $administrateurs = (new UtilisateurRepository())->selectAllOrderedAdminWithLimit();
        $organisateurs = (new UtilisateurRepository())->selectAllOrderedOrganisateurWithLimit();
        $utilisateurs = (new UtilisateurRepository())->selectAllUtilisateurBySearchValue($_REQUEST["searchValue"]);

        $this->showView("view.php", [
            "organisateurs" => $organisateurs,
            "utilisateurs" => $utilisateurs,
            "administrateurs" => $administrateurs,
            "pageTitle" => "utilisateurs",
            "pathBodyView" => "utilisateur/list.php"
        ]);
    }
}