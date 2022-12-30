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

class ControllerQuestion extends AbstractController
{
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
            if (!($_POST['dateDebutProposition'] < $_POST['dateFinProposition'] && $_POST['dateFinProposition'] < $_POST['dateDebutVote'] && $_POST['dateDebutVote'] < $_POST['dateFinVote'])) {
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

    public function readAll(): void
    {
        FormData::unsetAll();
        $this->showQuestions((new QuestionRepository)->selectAll());
    }

    private function showQuestions(array $questions)
    {
        $this->showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Questions",
            "pathBodyView" => "question/list.php"
        ]);
    }

    public function readAllByAlphabeticalOrder(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllOrdered());
    }

    public function readAllCurrentlyInWriting(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllCurrentlyInWriting());
    }

    public function readAllCurrentlyInVoting(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllCurrentlyInVoting());
    }

    public function readAllFinished(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllFinished());
    }

    public function readAllBySearchValue(): void
    {
        $this->showQuestions((new QuestionRepository())->selectAllBySearchValue($_GET["searchValue"]));
    }

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

    private function deleteParticipants(int $idQuestion)
    {
        (new VotantRepository)->delete($idQuestion);
        (new AuteurRepository)->delete($idQuestion);
    }

    public function delete(): void
    {
        $this->connectionCheck();
        if ($this->isOrganisateurOfQuestion((new QuestionRepository())->select($_GET["idQuestion"])->getLoginOrganisateur()) && $this->isOrganisateur()
            || $this->isAdmin()) {
            (new QuestionRepository())->delete($_GET["idQuestion"]);
            (new FlashMessage())->flash("deleted", "Votre question a été supprimée", FlashMessage::FLASH_SUCCESS);
        } else {
            (new FlashMessage())->flash("deleteFailed", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=readAll");
    }

    private function isOrganisateurOfQuestion($loginOrganisateur)
    {
        return ConnexionUtilisateur::isUser($loginOrganisateur);
    }
}