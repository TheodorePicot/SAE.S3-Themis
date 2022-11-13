<?php

namespace Themis\Controller;

use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionPropositionRepository;
use Themis\Model\Repository\SectionRepository;

class ControllerProposition extends AbstactController
{
    protected function getCreationMessage(): string
    {
        return "Création d'une proposition";
    }

    protected function getViewFolderName(): string
    {
        return "proposition";
    }

    public function create(): void
    {
        $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
        $question = (new QuestionRepository)->select($_GET['idQuestion']);

        $this->showView("view.php", [
            "sections" => $sections,
            "question" => $question,
            "pageTitle" => $this->getCreationMessage(),
            "pathBodyView" => $this->getViewFolderName() . "/create.php"
        ]);
    }

    public function created(): void
    {
        $proposition = (new PropositionRepository())->build($_GET);

        if ((new PropositionRepository)->create($proposition)) {
            $idProposition = DatabaseConnection::getPdo()->lastInsertId(); // Cette fonction nous permet d'obtenir l'id du dernier objet inséré dans une table.

            $sections = (new SectionRepository)->selectAllByQuestion($proposition->getIdQuestion()); //retourne un tableau de toutes les sections d'une question

            foreach ($sections as $section) {
                $sectionProposition = (new SectionPropositionRepository)->build(array('texteProposition' => $_GET['descriptionSectionProposition' . $section->getIdSection()], 'idSection' => $section->getIdSection(), 'idProposition' => $idProposition));
                (new SectionPropositionRepository)->create($sectionProposition);
            }
            $_GET['idProposition'] = $idProposition;
            $this->read();
        } else {
            $this->showError("Erreur de création de la question");
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
        $proposition = (new PropositionRepository())->build($_GET);

        (new PropositionRepository)->update($proposition);

        $sections = (new SectionRepository)->selectAllByQuestion($proposition->getIdQuestion()); //retourne un tableau de toutes les sections d'une question

        foreach ($sections as $section) {
            $sectionProposition = (new SectionPropositionRepository)->build(array('texteProposition' => $_GET['descriptionSectionProposition' . $section->getIdSection()], 'idSection' => $section->getIdSection(), 'idProposition' => $idProposition));
            (new SectionPropositionRepository)->update($sectionProposition);
        }

        $this->read();
    }
}
