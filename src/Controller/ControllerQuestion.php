<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Model\DataObject\Participant;
use Themis\Model\DataObject\Question;
use Themis\Model\DataObject\Section;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\CoAuteurRepository;
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
        if (!($_GET['dateDebutProposition'] < $_GET['dateFinProposition'] && $_GET['dateFinProposition'] < $_GET['dateDebutVote'] && $_GET['dateDebutVote'] < $_GET['dateFinVote'])) {
            (new FlashMessage())->flash("createdProblem", "Les dates ne sont pas cohérente", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }
        if ($this->isOrganisateurOfQuestion($_GET["loginOrganisateur"])
            && $this->isOrganisateur()
            || $this->isAdmin()) {
            (new QuestionRepository())->create(Question::buildFromForm($_GET));
            $idQuestion = DatabaseConnection::getPdo()->lastInsertId();

            $this->createParticipants($idQuestion);
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
        foreach ($_GET["votants"] as $votant) {
            $votantObject = new Participant($votant, $idQuestion);
            (new VotantRepository)->create($votantObject);
        }

        foreach ($_GET["auteurs"] as $auteur) {
            $auteurObject = new Participant($auteur, $idQuestion);
            (new AuteurRepository)->create($auteurObject);
        }
    }

    public function addSection(): void
    {
        $this->connectionCheck();
        if ($this->isOrganisateurOfQuestion($_GET["loginOrganisateur"])
            && $this->isOrganisateur()
            || $this->isAdmin()) {
            $this->updateInformationAuxiliary();
            (new SectionRepository)->create(new Section((int)null, $_GET["idQuestion"], "", ""));

            if (isset($_GET["isInCreation"]))
                $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion={$_GET["idQuestion"]}");
            else
                $this->redirect("frontController.php?action=update&idQuestion={$_GET["idQuestion"]}");
        } else {
            (new FlashMessage())->flash("createdProblem", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        }

    }

    private function updateInformationAuxiliary(): void
    {
        $this->connectionCheck();
        $question = Question::buildFromForm($_GET);
        (new QuestionRepository)->update($question);

        foreach ((new SectionRepository)->selectAllByQuestion($question->getIdQuestion()) as $section) {
            $updatedSection = new Section($section->getIdSection(), $section->getIdQuestion(), $_GET["titreSection{$section->getIdSection()}"], $_GET["descriptionSection{$section->getIdSection()}"]);
            (new SectionRepository)->update($updatedSection);
        }

        $this->deleteParticipants($question->getIdQuestion());
        $this->createParticipants($question->getIdQuestion());
    }

    public function update(): void
    {
        $this->connectionCheck();
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
        if ($this->isOrganisateurOfQuestion($question->getLoginOrganisateur())
            && $this->isOrganisateur()
            || $this->isAdmin()) {
            $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
            $utilisateurs = (new UtilisateurRepository)->selectAll();

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
     * @return void
     */
    private function readAuxiliary($question): void
    {
        $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
        $votants = (new VotantRepository)->selectAllByQuestion($_GET["idQuestion"]);
        $auteurs = (new AuteurRepository)->selectAllByQuestion($_GET["idQuestion"]);
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

    public function read(): void
    {
        $question = (new QuestionRepository())->select($_GET["idQuestion"]);
        if (ConnexionUtilisateur::isConnected()) {
            if ((in_array($question, (new QuestionRepository())->selectAllFinished()))
                || $this->isAdmin()
                || $this->isOrganisateurOfQuestion($question->getLoginOrganisateur()) && $this->isOrganisateur()
                || (new AuteurRepository)->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"])
                || (new CoAuteurRepository)->coAuteurIsInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"])
                || (in_array($question, (new QuestionRepository())->selectAllCurrentlyInVoting())
                    && (new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"]))
            ) {
                $this->readAuxiliary($question);
            } else {
                (new FlashMessage())->flash("readFailed", "Vous n'avez pas accès à cette question", FlashMessage::FLASH_DANGER);
                $this->redirect("frontController.php?action=readAll");
            }
        } else {
            if ((in_array($question, (new QuestionRepository())->selectAllFinished()))) {
                $this->readAuxiliary($question);
            } else {
                (new FlashMessage())->flash("readFailed", "Vous n'avez pas accès à cette question", FlashMessage::FLASH_DANGER);
                $this->redirect("frontController.php?action=readAll");
            }
        }
    }

    public function readAll(): void
    {
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
        if (date("d-m-y h:i:s") > $_GET['dateDebutVote']) {
            (new FlashMessage())->flash("notWhileVote", "Vous ne pouvez pas mettre à jour la question lors de la période de vote", FlashMessage::FLASH_SUCCESS);
        }
        if ($this->isOrganisateurOfQuestion($_GET['loginOrganisateur']) && $this->isOrganisateur()
            || $this->isAdmin()) {
            $this->updateInformationAuxiliary();

            if (isset($_GET["isInCreation"])) {
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
        if ($this->isOrganisateurOfQuestion($_GET["loginOrganisateur"])
            && $this->isOrganisateur()
            || $this->isAdmin()) {
            $this->updateInformationAuxiliary();
            (new SectionRepository)->delete($_GET["lastIdSection"]);

            if (isset($_GET["isInCreation"]))
                $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion={$_GET["idQuestion"]}");
            else
                $this->redirect("frontController.php?action=update&idQuestion={$_GET["idQuestion"]}");
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