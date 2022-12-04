<?php

namespace Themis\Controller;

use Themis\Lib\FlashMessage;
use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionPropositionRepository;
use Themis\Model\Repository\SectionRepository;

class ControllerProposition extends AbstactController
{
    public function create(): void
    {
        $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
        $question = (new QuestionRepository)->select($_GET['idQuestion']);

        $this->showView("view.php", [
            "sections" => $sections,
            "question" => $question,
            "pageTitle" => "Création Proposition",
            "pathBodyView" => "proposition/create.php"
        ]);
    }

    public function created(): void
    {
        $proposition = (new PropositionRepository)->build($_GET);
        $creationCode = (new PropositionRepository)->create($proposition);
        if ($creationCode == "") {
            $idProposition = DatabaseConnection::getPdo()->lastInsertId();

            $sections = (new SectionRepository)->selectAllByQuestion($proposition->getIdQuestion());
            foreach ($sections as $section) {
                $sectionProposition = (new SectionPropositionRepository)->build([
                    'texteProposition' => $_GET['descriptionSectionProposition' . $section->getIdSection()],
                    'idSection' => $section->getIdSection(),
                    'idProposition' => $idProposition
                ]);
                (new SectionPropositionRepository)->create($sectionProposition);
            }

            (new FlashMessage())->flash('created', 'Votre proposition a été créée', FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&idQuestion={$proposition->getIdQuestion()}");
        } else if ($creationCode == "23503") {
            (new FlashMessage())->flash('created', 'Vous n\'êtes pas auteur pour cette question', FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=read&idQuestion={$proposition->getIdQuestion()}");
        }
    }

    public function read(): void
    {
        $proposition = (new PropositionRepository)->select($_GET['idProposition']);
        $question = (new QuestionRepository)->select($proposition->getIdQuestion());
        $sections = (new SectionRepository())->selectAllByQuestion($question->getIdQuestion());

        $this->showView("view.php", [
            "proposition" => $proposition,
            "question" => $question,
            "sections" => $sections,
            "pageTitle" => "Info Proposition",
            "pathBodyView" => "proposition/read.php"
        ]);
    }

    public function readByQuestion(): void
    {
        $propositions = (new PropositionRepository)->selectByQuestion($_GET['idQuestion']);

        $this->showView("view.php", [
            "propositions" => $propositions,
            "pageTitle" => "Info Proposition",
            "pathBodyView" => "proposition/listByQuestion.php"
        ]);
    }

    public function update(): void
    {
        $proposition = (new PropositionRepository)->select($_GET['idProposition']);
        $question = (new QuestionRepository)->select($proposition->getIdQuestion());
        $sections = (new SectionRepository())->selectAllByQuestion($question->getIdQuestion());

        $this->showView("view.php", [
            "proposition" => $proposition,
            "question" => $question,
            "sections" => $sections,
            "pageTitle" => "Info Proposition",
            "pathBodyView" => "proposition/update.php"
        ]);
    }

    public function updated(): void
    {
        $proposition = (new PropositionRepository)->build($_GET);
        (new PropositionRepository)->update($proposition);

        $sections = (new SectionRepository)->selectAllByQuestion($proposition->getIdQuestion());
        foreach ($sections as $section) {
            $sectionsPropositionOld = (new SectionPropositionRepository())->selectByPropositionAndSection($proposition->getIdProposition(), $section->getIdSection());
            $sectionPropositionNew = (new SectionPropositionRepository)->build(
                ['texteProposition' => $_GET['descriptionSectionProposition' . $section->getIdSection()],
                    'idSection' => $section->getIdSection(),
                    'idProposition' => $proposition->getIdProposition(),
                    'idSectionProposition' => $sectionsPropositionOld->getIdSectionProposition()
                ]);
            (new SectionPropositionRepository)->update($sectionPropositionNew);
        }

        (new FlashMessage())->flash('created', 'Votre proposition a été mise à jour', FlashMessage::FLASH_SUCCESS);

        header("Location: frontController.php?action=read&idQuestion={$proposition->getIdQuestion()}");
    }

    public function delete(): void
    {
        if ((new PropositionRepository)->delete($_GET['idProposition'])) {

            (new FlashMessage())->flash('created', 'Votre proposition a bien été supprimée', FlashMessage::FLASH_SUCCESS);
            header("Location: frontController.php?action=read&idQuestion={$_GET['idQuestion']}");
        }
    }
}
