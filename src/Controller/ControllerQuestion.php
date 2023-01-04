<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Lib\FormData;
use Themis\Model\DataObject\Participant;
use Themis\Model\DataObject\Question;
use Themis\Model\DataObject\Section;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionRepository;
use Themis\Model\Repository\UtilisateurRepository;
use Themis\Model\Repository\VotantRepository;

/**
 *
 */
class ControllerQuestion extends AbstractController
{
    /**
     * Créer une question avec les informations du formulaire envoyé par l'organisateur
     *
     * Cette méthode est appelée quand un organisateur soumet les informations du formulaire dans {@link src/View/question/create.php}
     * Elle fait des verification de droits et de cohérence de date.
     * Si toutes ces vérifications sont validées, elle créée une {@link Question} puis elle insère les données de cet objet dans la base de données.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     *
     *
     * @return void
     */
    public function created(): void
    {
        $this->connectionCheck();
        if ($this->isOrganisateurOfQuestion($_POST["loginOrganisateur"])
            && $this->isOrganisateur()
            || $this->isAdmin()) {
            $dateOneDay = date_add(date_create(), date_interval_create_from_date_string("1 minute"));
            if ($dateOneDay->format("Y-m-d H:i:s") >= $_POST['dateDebutProposition']) {
                FormData::saveFormData("createQuestion");
                (new FlashMessage())->flash("createdProblem", "Il faut au moins une minute de préparation pour la question", FlashMessage::FLASH_WARNING);
                $this->redirect("frontController.php?action=create");
            }
            if (!($_POST['dateDebutProposition'] < $_POST['dateFinProposition'] && $_POST['dateFinProposition'] <= $_POST['dateDebutVote'] && $_POST['dateDebutVote'] < $_POST['dateFinVote'])) {
                FormData::saveFormData("createQuestion");
                (new FlashMessage())->flash("createdProblem", "Les dates ne sont pas cohérente", FlashMessage::FLASH_WARNING);
                $this->redirect("frontController.php?action=create");
            }
            (new QuestionRepository())->create(Question::buildFromForm($_POST));
            $idQuestion = DatabaseConnection::getPdo()->lastInsertId();

            $this->createParticipants($idQuestion);
            FormData::deleteFormData("createQuestion");
            $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion=$idQuestion");
        } else {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Permet de rediriger l'organisateur vers la vue {@link src/View/question/create.php} pour qu'il puisse créer une question
     *
     * Cette méthode fait des verification de droits et de cohérence de date.
     * Si toutes ces vérifications sont validées, elle redirige l'utilisateur dans la vue {@link src/View/question/create.php}.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     *
     * @return void
     */
    public function create(): void
    {
        $this->connectionCheck();
        if ($this->isOrganisateur()
            || $this->isAdmin()) {
            $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();
            $this->showView("view.php", [
                "utilisateurs" => $utilisateurs,
                "pageTitle" => "Création Question",
                "pathBodyView" => "question/create.php"
            ]);
        } else {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Méthode auxiliaire permettant d'ajouter des participants à une question
     * c.-à-d. les auteurs et les votants
     *
     * @param int $idQuestion
     * @return void
     */
    private function createParticipants(int $idQuestion)
    {
        foreach ($_POST["votants"] as $votant) {
            $votantObject = new Participant($votant, $idQuestion);
            (new VotantRepository)->create($votantObject);
        }

        foreach ($_POST["auteurs"] as $auteur) {
            $auteurObject = new Participant($auteur, $idQuestion);
            (new AuteurRepository)->create($auteurObject);
        }
    }

    /**
     * Méthode auxiliaire que l'organisateur peut appeler durant la création ou la mise à jour de la question.
     * Elle ajoute une section à la question dans la base de données puis redirige l'organisateur vers la creation/mise à jour
     * de la question pour qu'il continue ses ajouts/modifications.
     *
     * @return void
     */
    public function addSection(): void
    {
        $this->connectionCheck();
        if ($this->isOrganisateurOfQuestion($_POST["loginOrganisateur"])
            && $this->isOrganisateur()
            || $this->isAdmin()) {
            $this->updateInformationAuxiliary();
            (new SectionRepository)->create(new Section((int)null, $_POST["idQuestion"], "", ""));

            if (isset($_POST["isInCreation"]))
                $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion={$_POST["idQuestion"]}");
            else
                $this->redirect("frontController.php?action=update&idQuestion={$_POST["idQuestion"]}");
        } else {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }

    }

    /**
     * Méthode auxiliaire qui fait les requêtes de mises à jour de la question dans la base de données
     *
     * Cette méthode a été implémentée pour éviter la duplication de code
     *
     * @return void
     */
    private function updateInformationAuxiliary(): void
    {
        $this->connectionCheck();
        $question = Question::buildFromForm($_POST);
        (new QuestionRepository)->update($question);

        foreach ((new SectionRepository)->selectAllByQuestion($question->getIdQuestion()) as $section) {
            $updatedSection = new Section($section->getIdSection(), $section->getIdQuestion(), $_POST["titreSection{$section->getIdSection()}"], $_POST["descriptionSection{$section->getIdSection()}"]);
            (new SectionRepository)->update($updatedSection);
        }

        $this->deleteParticipants($question->getIdQuestion());
        $this->createParticipants($question->getIdQuestion());
    }

    /**
     * Permet de rediriger l'organisateur vers la vue {@link src/View/question/update.php} pour qu'il puisse mettre à jour sa question
     *
     * Méthode appelée par l'organisateur quand il est dans la vue {@link src/View/question/read.php}
     * Elle fait des verification de droits et de cohérence de date.
     * Si toutes ces vérifications sont validées, elle redirige l'utilisateur dans la vue {@link src/View/question/update.php}.
     * Sinon, elle renvoie un message d'erreur et redirige vers une autre vue.
     *
     * @return void
     */
    public function update(): void
    {
        $this->connectionCheck();
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);

        if (date_create()->format("Y-m-d H:i:s") > $question->getDateDebutProposition()) {
            (new FlashMessage())->flash("notWhileVote", "Vous ne pouvez plus mettre à jour la question", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&idQuestion={$_GET["idQuestion"]}");
        }
        if ($this->isOrganisateurOfQuestion($question->getLoginOrganisateur())
            && $this->isOrganisateur()
            || $this->isAdmin()) {
            $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
            $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();

            if (isset($_GET["isInCreation"])) $message = "Création de votre question";
            else $message = "Mise à jour question";

            $this->showView("view.php", [
                "utilisateurs" => $utilisateurs,
                "sections" => $sections,
                "question" => $question,
                "message" => $message,
                "pageTitle" => $message,
                "pathBodyView" => "question/update.php"
            ]);
        } else {
            (new FlashMessage())->flash("updateFailed", "Vous n'avez pas accès à cette méthode (update)", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Permet de lire la question sélectionnée
     *
     * Cette méthode charge les données nécessaires puis fait appelle à {@link AbstractController::showView()}
     * pour afficher la vue {@link src/View/question/read.php}.
     *
     * @return void
     */
    public function read(): void
    {
        FormData::unsetAll();
        $question = (new QuestionRepository())->select($_GET["idQuestion"]);
        $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
        $votants = (new VotantRepository)->selectAllByQuestion($_GET["idQuestion"]);
        $auteurs = (new AuteurRepository)->selectAllByQuestion($_GET["idQuestion"]);
        if (date_create()->format("Y-m-d H:i:s") > $question->getDateFinVote())
            $propositions = (new PropositionRepository)->selectAllByQuestionOrderedByVoteValue($_GET["idQuestion"]);
        else
            $propositions = (new PropositionRepository)->selectByQuestion($_GET["idQuestion"]);

        $this->showView("view.php", [
            "propositions" => $propositions,
            "sections" => $sections,
            "question" => $question,
            "votants" => $votants,
            "auteurs" => $auteurs,
            "pageTitle" => "Info question",
            "pathBodyView" => "question/read.php"
        ]);
    }

    /**
     * Affiche toutes les questions
     *
     * Cette méthode est utilisée pour récupérer toutes les questions de la base de données puis les afficher
     * avec la vue : {@link src/View/question/list.php}
     * @return void
     */
    public function readAll(): void
    {
        FormData::unsetAll();
        $this->showQuestions((new QuestionRepository)->selectAll());
    }

    /**
     * Méthode auxiliaire permettant d'afficher les questions données en paramètres
     *
     * @param array $questions Les questions que l'on souhaite afficher
     * @return void
     */
    private function showQuestions(array $questions)
    {
        $this->showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Questions",
            "pathBodyView" => "question/list.php"
        ]);
    }

    /**
     * Affiche toutes les questions par ordre alphabétique
     *
     * @return void
     */
    public function readAllByAlphabeticalOrder(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllOrdered());
    }

    /**
     * Affiche toutes les questions en cours d'écriture
     *
     * @return void
     */
    public function readAllCurrentlyInWriting(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllCurrentlyInWriting());
    }

    /**
     * Affiche toutes les questions en cours de vote
     *
     * @return void
     */
    public function readAllCurrentlyInVoting(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllCurrentlyInVoting());
    }

    /**
     * Affiche toutes les questions terminées
     *
     * @return void
     */
    public function readAllFinished(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllFinished());
    }

    /**
     * Affiche toutes les questions par rapport au texte que l'utilisateur a mis dans la barre de recherche
     *
     * @return void
     */
    public function readAllBySearchValue(): void
    {
        $this->showQuestions((new QuestionRepository())->selectAllBySearchValue($_GET["searchValue"]));
    }

    /**
     * @return void
     */
    public function updated(): void
    {
        $this->connectionCheck();
        if (!$this->isAdmin()) {
            $oldQuestion = (new QuestionRepository)->select($_POST["idQuestion"]);
            if (date_create()->format("Y-m-d H:i:s") > $oldQuestion->getDateDebutProposition()) {
                (new FlashMessage())->flash("notWhileVote", "Vous ne pouvez plus mettre à jour la question", FlashMessage::FLASH_SUCCESS);
                $this->redirect("frontController.php?action=readAll");
            }
            if ($_POST['dateDebutProposition'] < $oldQuestion->getDateDebutProposition()) {
                (new FlashMessage())->flash("createdProblem", "Vous pouvez uniquement ajouter du temps d'attente", FlashMessage::FLASH_WARNING);
                $this->redirect("frontController.php?action=readAll");
            }
            if (!($_POST['dateDebutProposition'] < $_POST['dateFinProposition'] && $_POST['dateFinProposition'] < $_POST['dateDebutVote'] && $_POST['dateDebutVote'] < $_POST['dateFinVote'])) {
                (new FlashMessage())->flash("createdProblem", "Les dates ne sont pas cohérente", FlashMessage::FLASH_WARNING);
                $this->redirect("frontController.php?action=readAll");
            }
        }
        if ($this->isOrganisateurOfQuestion($_POST['loginOrganisateur']) && $this->isOrganisateur()
            || $this->isAdmin()) {
            $this->updateInformationAuxiliary();

            if (isset($_POST["isInCreation"])) {
                (new FlashMessage())->flash("created", "Votre question a été créée", FlashMessage::FLASH_SUCCESS);
            } else {
                (new FlashMessage())->flash("updated", "Votre question a été mise à jour", FlashMessage::FLASH_SUCCESS);
            }
        } else {
            (new FlashMessage())->flash("updatedFailed", "Vous n'avez pas accès à cette méthode (updated)", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=readAll");
    }

    /**
     * @return void
     */
    public function deleteLastSection(): void
    {
        $this->connectionCheck();
        if ($this->isOrganisateurOfQuestion($_POST["loginOrganisateur"])
            && $this->isOrganisateur()
            || $this->isAdmin()) {
            $this->updateInformationAuxiliary();
            (new SectionRepository)->delete($_POST["lastIdSection"]);

            if (isset($_POST["isInCreation"]))
                $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion={$_POST["idQuestion"]}");
            else
                $this->redirect("frontController.php?action=update&idQuestion={$_POST["idQuestion"]}");
        } else {
            (new FlashMessage())->flash("updatedFailed", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * @param int $idQuestion
     * @return void
     */
    private function deleteParticipants(int $idQuestion)
    {
        (new VotantRepository)->delete($idQuestion);
        (new AuteurRepository)->delete($idQuestion);
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->connectionCheck();
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
        if (date_create()->format("Y-m-d H:i:s") > $question->getDateFinVote()) {
            (new FlashMessage())->flash("notWhileVote", "Vous ne pouvez plus supprimer la question", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&idQuestion={$_GET["idQuestion"]}");
        }
        if ($this->isOrganisateurOfQuestion($question->getLoginOrganisateur()) && $this->isOrganisateur()
            || $this->isAdmin()) {
            (new QuestionRepository())->delete($_GET["idQuestion"]);
            (new FlashMessage())->flash("deleted", "Votre question a été supprimée", FlashMessage::FLASH_SUCCESS);
        } else {
            (new FlashMessage())->flash("deleteFailed", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=readAll");
    }

    /**
     * @param $loginOrganisateur
     * @return bool
     */
    private function isOrganisateurOfQuestion($loginOrganisateur)
    {
        return ConnexionUtilisateur::isUser($loginOrganisateur);
    }
}