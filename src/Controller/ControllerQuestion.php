<?php

namespace Themis\Controller;

use Themis\Model\DataObject\Participant;
use Themis\Model\DataObject\Section;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionRepository;
use Themis\Model\Repository\UtilisateurRepository;
use Themis\Model\Repository\VotantRepository;
use Themis\Lib\FlashMessage;

class ControllerQuestion extends AbstactController
{
    public function create(): void
    {
        $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();
        $this->showView("view.php", [
            "utilisateurs" => $utilisateurs,
            "pageTitle" => "Création Question",
            "pathBodyView" => "question/create.php"
        ]);
    }

    public function created(): void
    {
        (new QuestionRepository)->create((new QuestionRepository)->build($_GET));
        $idQuestion = DatabaseConnection::getPdo()->lastInsertId();

        (new ControllerUtilisateur)->createParticipants($idQuestion);
        $this->redirect("frontController.php?isInCreation=yes&action=update&idQuestion=$idQuestion");
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

    public function read(): void
    {
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
    }

    public function showQuestions(array $questions)
    {
        $this->showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Questions",
            "pathBodyView" => "question/list.php"
        ]);
    }

    public function readAll(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAll());
    }

    public function readAllByAlphabeticalOrder()
    {
        $this->showQuestions((new QuestionRepository)->selectAllOrdered());
    }

    public function readAllCurrentlyInWriting(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllWrite());
    }

    public function readAllCurrentlyInVoting(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllVote());
    }

    public function readAllFinished(): void
    {
        $this->showQuestions((new QuestionRepository)->selectAllFinish());
    }

    public function search(): void
    {
        $this->showQuestions((new QuestionRepository())->search($_GET['element']));
    }

    public function update(): void
    {
        $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
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

    public function updateInformationAuxiliary()
    {
        $question = (new QuestionRepository)->build($_GET);
        (new QuestionRepository)->update($question);

        foreach ((new SectionRepository)->selectAllByQuestion($question->getIdQuestion()) as $section) {
            $updatedSection = new Section($section->getIdSection(), $section->getIdQuestion(), $_GET['titreSection' . $section->getIdSection()], $_GET['descriptionSection' . $section->getIdSection()]);
            (new SectionRepository)->update($updatedSection);
        }

        (new ControllerUtilisateur())->deleteParticipants($question->getIdQuestion());
        (new ControllerUtilisateur())->createParticipants($question->getIdQuestion());
    }

    public function updated(): void
    {
        $this->updateInformationAuxiliary();

        if (isset($_GET['isInCreation'])) {
            (new FlashMessage())->flash('created', 'Votre question a été créée', FlashMessage::FLASH_SUCCESS);
        } else {
            (new FlashMessage())->flash('updated', 'Votre question a été mise à jour', FlashMessage::FLASH_SUCCESS);
        }
        $this->redirect("frontController.php?action=readAll");
    }

    public function delete(): void
    {
        if ((new QuestionRepository())->delete($_GET['idQuestion'])) {
            (new FlashMessage())->flash('deleted', 'Votre question a été supprimée', FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=readAll");
        } else {
            (new FlashMessage())->flash('deleteFailed', 'Il y a eu une erreur lors de la suppréssion de la question', FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=readAll");
        }
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
}