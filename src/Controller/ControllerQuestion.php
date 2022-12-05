<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
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
        if ((new QuestionRepository)->create((new QuestionRepository)->build($_GET)) == "23503") {
            (new FlashMessage())->flash("created", "Il faut être connecté pour créer une question", FlashMessage::FLASH_WARNING);
            $this->redirect("frontController.php?action=readAll");
        } else {
            $idQuestion = DatabaseConnection::getPdo()->lastInsertId();

            (new ControllerUtilisateur)->createParticipants($idQuestion);
            $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion=$idQuestion");
        }
    }

    public function create(): void
    {
        $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();
        $this->showView("view.php", [
            "utilisateurs" => $utilisateurs,
            "pageTitle" => "Création Question",
            "pathBodyView" => "question/create.php"
        ]);
    }

    public function addSection(): void
    {
        $this->updateInformationAuxiliary();
        (new SectionRepository)->create(new Section((int)null, $_GET["idQuestion"], "", ""));

        if (isset($_GET["isInCreation"]))
            $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion={$_GET["idQuestion"]}");
        else
            $this->redirect("frontController.php?action=update&idQuestion={$_GET["idQuestion"]}");
    }

    public function updateInformationAuxiliary(): void
    {
        $question = (new QuestionRepository)->build($_GET);
        (new QuestionRepository)->update($question);

        foreach ((new SectionRepository)->selectAllByQuestion($question->getIdQuestion()) as $section) {
            $updatedSection = new Section($section->getIdSection(), $section->getIdQuestion(), $_GET["titreSection" . $section->getIdSection()], $_GET["descriptionSection" . $section->getIdSection()]);
            (new SectionRepository)->update($updatedSection);
        }

        (new ControllerUtilisateur())->deleteParticipants($question->getIdQuestion());
        (new ControllerUtilisateur())->createParticipants($question->getIdQuestion());
    }

    public function update(): void
    {
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
        if (!ConnexionUtilisateur::isUser($question->getLoginOrganisateur())) {
            (new FlashMessage())->flash("updateFailed", "Vous n'avez pas accès à la mise à jour de cette question", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        } else {
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
        }
    }

    public function read(): void
    {
        $question = (new QuestionRepository())->select($_GET["idQuestion"]);
        if (ConnexionUtilisateur::isUser($question->getLoginOrganisateur())
            || (new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"]) // TODO Ajouter condition pour co-auteur
            || (in_array($question, (new QuestionRepository())->selectAllCurrentlyInVoting())
                && (new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"]))
            ) {
            $question = (new QuestionRepository)->select($_GET["idQuestion"]);
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
        } else {
            (new FlashMessage())->flash("readFailed", "Vous n'avez pas accès à cette question", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function readAll(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAll());
    }

    public function showQuestions(array $questions)
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
        if (!ConnexionUtilisateur::isUser($_GET['loginOrganisateur'])) {
            (new FlashMessage())->flash("updatedFailed", "Vous n'êtes pas le créateur de cette question", FlashMessage::FLASH_DANGER);
        } else {
            $this->updateInformationAuxiliary();

            if (isset($_GET["isInCreation"])) {
                (new FlashMessage())->flash("created", "Votre question a été créée", FlashMessage::FLASH_SUCCESS);
            } else {
                (new FlashMessage())->flash("updated", "Votre question a été mise à jour", FlashMessage::FLASH_SUCCESS);
            }
        }
        $this->redirect("frontController.php?action=readAll");
    }

    public function deleteLastSection(): void
    {
        $this->updateInformationAuxiliary();
        (new SectionRepository)->delete($_GET["lastIdSection"]);

        if (isset($_GET["isInCreation"]))
            $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion={$_GET["idQuestion"]}");
        else
            $this->redirect("frontController.php?action=update&idQuestion={$_GET["idQuestion"]}");
    }

    public function delete(): void
    {
        if (ConnexionUtilisateur::getConnectedUserLogin() != (new QuestionRepository())->select($_GET["idQuestion"])->getLoginOrganisateur()) {
            (new FlashMessage())->flash("deleteFailed", "Vous n'êtes pas le créateur de cette question", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        } else if ((new QuestionRepository())->delete($_GET["idQuestion"])) {
            (new FlashMessage())->flash("deleted", "Votre question a été supprimée", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=readAll");
        } else {
            (new FlashMessage())->flash("deleteFailed", "Il y a eu une erreur lors de la suppression de la question", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=readAll");
        }
    }
}