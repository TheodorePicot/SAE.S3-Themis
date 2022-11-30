<?php

namespace Themis\Controller;

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
        (new PropositionRepository)->create($proposition);

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

        header("Location: frontController.php?action=read&controller=proposition&idProposition=$idProposition");
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

        $this->read();
    }

    public function delete(): void
    {
        if ((new PropositionRepository)->delete($_GET['idProposition'])) {
            $propositions = (new PropositionRepository)->selectByQuestion($_GET['idQuestion']);

            $this->showView("view.php", [
                "propositions" => $propositions,
                "pageTitle" => "Info Proposition",
                "pathBodyView" => "proposition/deleted.php"
            ]);
        }
    }
}
