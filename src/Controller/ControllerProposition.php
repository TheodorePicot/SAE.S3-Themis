<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Lib\FormData;
use Themis\Model\DataObject\CoAuteur;
use Themis\Model\DataObject\Proposition;
use Themis\Model\DataObject\Question;
use Themis\Model\DataObject\SectionProposition;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\CoAuteurRepository;
use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionPropositionRepository;
use Themis\Model\Repository\SectionRepository;
use Themis\Model\Repository\UtilisateurRepository;
use Themis\Model\Repository\VotantRepository;

/**
 * Classe dédiée aux fonctions CRUD et autres des propositions
 */
class ControllerProposition extends AbstractController
{
    /**
     * Créer une proposition avec les informations du formulaire envoyé par l'auteur
     *
     * Cette méthode est appelée quand un auteur soumet les informations du formulaire dans {@link src/View/proposition/create.php}
     * puis elle créée une {@link Proposition}. Elle fait des verification de droits et de cohérence de date.
     * Si toutes ces vérifications sont validées, elle insère les données dans la base de données.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     *
     *
     * @return void
     */
    public function created(): void
    {
        $this->connectionCheck();
        $proposition = Proposition::buildFromForm($_POST);
        $question = (new QuestionRepository)->select($proposition->getIdQuestion());
        if (date_create()->format("Y-m-d H:i:s") < $question->getDateDebutProposition()) {
            (new FlashMessage())->flash("tooLate", "La question n'est pas encore en cours d'écriture", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
        if (date_create()->format("Y-m-d H:i:s") > $question->getDateFinProposition()) {
            (new FlashMessage())->flash("tooLate", "La question n'est plus en cours d'écriture", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
        if ($this->isAuteurInQuestion($proposition->getIdQuestion())
            || $this->isAdmin()) {
            $creationCode = (new PropositionRepository)->create($proposition);
            if ($creationCode == "") {
                $idProposition = DatabaseConnection::getPdo()->lastInsertId();

                $sections = (new SectionRepository)->selectAllByQuestion($proposition->getIdQuestion());
                // Pour toutes les sections de la question, on crée une section pour la proposition
                foreach ($sections as $section) {
                    $sectionProposition = SectionProposition::buildFromForm([
                        "texteProposition" => $_POST["descriptionSectionProposition{$section->getIdSection()}"],
                        "idSection" => $section->getIdSection(),
                        "idProposition" => $idProposition
                    ]);
                    (new SectionPropositionRepository)->create($sectionProposition);
                }
                if (isset($_POST["coAuteurs"])) {
                    foreach ($_POST["coAuteurs"] as $coAuteur) {
                        $coAuteurObject = new CoAuteur($idProposition, $coAuteur);
                        (new CoAuteurRepository)->create($coAuteurObject);
                    }
                }
                (new FlashMessage())->flash("created", "Votre proposition a été créée", FlashMessage::FLASH_SUCCESS);
                $this->redirect("frontController.php?action=read&idQuestion={$proposition->getIdQuestion()}");
            } else if ($creationCode == "23000") {
                (new FlashMessage())->flash("alreadyProposition", "Vous avez déjà créer une proposition", FlashMessage::FLASH_WARNING);
            } else {
                (new FlashMessage())->flash("unknownError", "Erreur (CODE : $creationCode)", FlashMessage::FLASH_DANGER);
            }
        } else {
            (new FlashMessage())->flash("notAuthor", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=readAll");
    }

    /**
     * Permet de rediriger l'auteur vers la vue {@link src/View/proposition/create.php} pour qu'il puisse créer une proposition
     *
     * Méthode appelée par l'auteur quand il est dans la vue {@link src/View/proposition/listByQuestion.php}.
     * Elle fait des verification de droits et de cohérence de date.
     * Si toutes ces vérifications sont validées, elle redirige l'utilisateur dans la vue {@link src/View/proposition/create.php}.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     *
     *
     * @return void
     */
    public function create(): void
    {
        $this->connectionCheck();
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
        if (date_create()->format("Y-m-d H:i:s") < $question->getDateDebutProposition()) {
            (new FlashMessage())->flash("tooLate", "La question n'est pas encore en cours d'écriture", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
        if (date_create()->format("Y-m-d H:i:s") > $question->getDateFinProposition()) {
            (new FlashMessage())->flash("tooLate", "La question n'est plus en cours d'écriture", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
        if ($this->isAuteurInQuestion($_GET["idQuestion"])
            || $this->isAdmin()) {
            $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
            $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();
            $this->showView("view.php", [
                "utilisateurs" => $utilisateurs,
                "sections" => $sections,
                "question" => $question,
                "pageTitle" => "Création Proposition",
                "pathBodyView" => "proposition/create.php"
            ]);
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Permet de lire la proposition sélectionnée
     *
     * Cette méthode charge les données nécessaires puis fait appelle à {@link AbstractController::showView()}
     * pour afficher la vue {@link src/View/proposition/read.php}.
     *
     * @return void
     */
    public function read(): void
    {
        /** Pour supprimer les données des formulaires stockées dans {@var $_SESSION} car elles ne sont plus utiles */
        FormData::unsetAll();
        $proposition = (new PropositionRepository)->select($_GET["idProposition"]);
        $question = (new QuestionRepository)->select($proposition->getIdQuestion());
        $this->connectionCheck();
        if ($this->hasReadAccess($question, $proposition)) {
            $sections = (new SectionRepository())->selectAllByQuestion($question->getIdQuestion());
            $coAuteurs = (new CoAuteurRepository())->selectAllByProposition($proposition->getIdProposition());
            $this->showView("view.php", [
                "coAuteurs" => $coAuteurs,
                "proposition" => $proposition,
                "question" => $question,
                "sections" => $sections,
                "pageTitle" => "Info Proposition",
                "pathBodyView" => "proposition/read.php"
            ]);
        } else {
            (new FlashMessage())->flash("createFailed", "Cette proposition est privée", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }

    }

    public function hasReadAccess(Question $question, Proposition $proposition) {
        return ( date_create()->format("Y-m-d H:i:s") >= $question->getDateDebutProposition() &&
                date_create()->format("Y-m-d H:i:s") < $question->getDateFinProposition() &&
                $this->isAuteurOfProposition($proposition->getIdProposition()) ||
                $this->isCoAuteurInProposition($proposition->getIdProposition()) )
            ||
            ( date_create()->format("Y-m-d H:i:s") >= $question->getDateDebutVote() &&
                date_create()->format("Y-m-d H:i:s") < $question->getDateFinProposition() &&
                $this->isAuteurInQuestion($question->getIdQuestion()) ||
                $this->isCoAuteurInQuestion($question->getIdQuestion()) ||
                $this->isVotantInQuestion($question->getIdQuestion()) )
            ||
            date_create()->format("Y-m-d H:i:s") > $question->getDateFinProposition();

    }

    /**
     * Liste toutes les questions appartenant à une question
     *
     * @return void
     */
    public function readByQuestion(): void
    {
        $propositions = (new PropositionRepository)->selectByQuestion($_GET["idQuestion"]);

        $this->showView("view.php", [
            "propositions" => $propositions,
            "pageTitle" => "Info Proposition",
            "pathBodyView" => "proposition/listByQuestion.php"
        ]);
    }

    /**
     * Met à jour une proposition avec les informations du formulaire envoyé par l'auteur
     *
     * Cette méthode est appelée quand un auteur soumet les informations du formulaire dans {@link src/View/proposition/update.php}
     * puis elle créée une {@link Proposition} qui représente la nouvelle version de la proposition.
     * Elle fait des verification de droits et de cohérence de date.
     * Si toutes ces vérifications sont validées, elle met à jour les données de la proposition dans la base de données.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     *
     * @return void
     */
    public function updated(): void
    {
        $this->connectionCheck();
        $proposition = Proposition::buildFromForm($_POST);
        $question = (new QuestionRepository)->select($proposition->getIdQuestion());
        if (date_create()->format("Y-m-d H:i:s") > $question->getDateFinProposition()) {
            (new FlashMessage())->flash("tooLate", "La question n'est plus en cours d'écriture", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
        if ($this->isAuteurInQuestion($_POST["idQuestion"]) && $this->isAuteurOfProposition($_POST["idProposition"])
            || $this->isCoAuteurInProposition($_POST["idProposition"])
            || $this->isAdmin()) {
            (new PropositionRepository)->update($proposition);
            $sections = (new SectionRepository)->selectAllByQuestion($proposition->getIdQuestion());

            foreach ($sections as $section) {
                $sectionsPropositionOld = (new SectionPropositionRepository())->selectByPropositionAndSection($proposition->getIdProposition(), $section->getIdSection());
                $sectionPropositionNew = SectionProposition::buildFromForm([
                    "texteProposition" => $_POST["descriptionSectionProposition{$section->getIdSection()}"],
                    "idSection" => $section->getIdSection(),
                    "idProposition" => $proposition->getIdProposition(),
                    "idSectionProposition" => $sectionsPropositionOld->getIdSectionProposition()
                ]);
                (new SectionPropositionRepository)->update($sectionPropositionNew);
            }

            // Mise à jour des coAuteur en les supprimant puis en insérant les coAuteurs de la nouvelle liste
            (new CoAuteurRepository())->delete($proposition->getIdProposition());
            if (isset($_POST["coAuteurs"])) {
                foreach ($_POST["coAuteurs"] as $coAuteur) {
                    $coAuteurObject = new CoAuteur($proposition->getIdProposition(), $coAuteur);
                    (new CoAuteurRepository())->create($coAuteurObject);
                }
            }
            (new FlashMessage())->flash("created", "Votre proposition a été mise à jour", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&idQuestion={$proposition->getIdQuestion()}");
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Permet de rediriger l'auteur vers la vue {@link src/View/proposition/update.php} pour qu'il puisse mettre à jour sa proposition
     *
     * Méthode appelée par l'auteur quand il est dans la vue {@link src/View/proposition/read.php}
     * Elle fait des verification de droits et de cohérence de date.
     * Si toutes ces vérifications sont validées, elle redirige l'utilisateur dans la vue {@link src/View/proposition/update.php}.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     *
     * @return void
     */
    public function update(): void
    {
        $this->connectionCheck();
        /** Pour supprimer les données des formulaires stockées dans {@var $_SESSION} car elles ne sont plus utiles */
        FormData::unsetAll();
        $proposition = (new PropositionRepository)->select($_GET["idProposition"]);
        $question = (new QuestionRepository)->select($proposition->getIdQuestion());
        if (date_create()->format("Y-m-d H:i:s") > $question->getDateFinProposition()) {
            (new FlashMessage())->flash("tooLate", "La question n'est plus en cours d'écriture", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
        if ($this->isAuteurInQuestion($question->getIdQuestion()) && $this->isAuteurOfProposition($_GET["idProposition"])
            || $this->isCoAuteurInProposition($_GET["idProposition"])
            || $this->isAdmin()) {
            $sections = (new SectionRepository())->selectAllByQuestion($question->getIdQuestion());
            $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();

            $this->showView("view.php", [
                "utilisateurs" => $utilisateurs,
                "proposition" => $proposition,
                "question" => $question,
                "sections" => $sections,
                "pageTitle" => "Info Proposition",
                "pathBodyView" => "proposition/update.php"
            ]);
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Supprime une proposition
     *
     * Elle fait des verification de droits et de cohérence de date.
     * Si toutes ces vérifications sont validées, elle supprime la proposition de la base de données
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     * @return void
     */
    public function delete(): void
    {
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
        if (date_create()->format("Y-m-d H:i:s") > $question->getDateFinProposition()) {
            (new FlashMessage())->flash("tooLate", "Vous ne pouvez pas supprimer votre proposition après la période d'écriture", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
        $this->connectionCheck();
        if ($this->isAuteurInQuestion($_GET["idQuestion"]) && $this->isAuteurOfProposition($_GET["idProposition"])
            || $this->isAdmin()) {
            if ((new PropositionRepository)->delete($_GET["idProposition"])) {
                (new FlashMessage())->flash("deleted", "Votre proposition a bien été supprimée", FlashMessage::FLASH_SUCCESS);
            } else {
                (new FlashMessage())->flash("deleteFailed", "Il y a eu une erreur lors de la suppression de la proposition", FlashMessage::FLASH_DANGER);
            }
            $this->redirect("frontController.php?action=read&idQuestion={$_GET["idQuestion"]}");
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Permet de savoir si l'utilisateur est auteur de la question sélectionnée
     *
     * @param int $idQuestion La question dans laquelle on regarde si l'utilisateur est auteur
     * @return bool
     */
    private function isAuteurInQuestion(int $idQuestion): bool
    {
        return (new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $idQuestion);
    }

    private function isCoAuteurInQuestion(int $idQuestion): bool
    {
        return (new CoAuteurRepository)->isCoAuteurInProposition(ConnexionUtilisateur::getConnectedUserLogin(), $idQuestion);
    }


    /**
     * Permet de savoir si l'utilisateur est co-auteur de la question sélectionnée
     *
     * @param int $idProposition La proposition dans laquelle on regarde si l'utilisateur est coAuteur
     * @return bool
     */
    private function isCoAuteurInProposition(int $idProposition): bool
    {
        return (new CoAuteurRepository())->isCoAuteurInProposition(ConnexionUtilisateur::getConnectedUserLogin(), $idProposition);
    }

    /**
     * @param int $idProposition La proposition dans laquelle on regarde si l'utilisateur est Auteur
     * @return bool
     */
    private function isAuteurOfProposition(int $idProposition): bool
    {
        return ConnexionUtilisateur::isUser((new PropositionRepository())->select($idProposition)->getLoginAuteur());
    }

    private function isVotantInQuestion(int $idQuestion): bool
    {
        return (new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $idQuestion);
    }

}
