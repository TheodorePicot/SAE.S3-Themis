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

    public function create()
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
                echo 'descriptionSectionProposition' . $section->getIdSection();
                $sectionProposition = (new SectionPropositionRepository)->build(array('texteProposition' => $_GET['descriptionSectionProposition' . $section->getIdSection()], 'idSection' => $section->getIdSection(), 'idProposition' => $idProposition));
                (new SectionPropositionRepository)->create($sectionProposition);
            }

            (new ControllerQuestion)->readAll();
        } else {
            $this->showError("Erreur de création de la question");
        }
    }

    public function read()
    {
        $proposition = (new PropositionRepository)->select($_GET['idProposition']);
        $question = (new QuestionRepository)->select($_GET['idQuestion']);
        $sectionsProposition =(new SectionPropositionRepository)->selectAllByProposition($_GET['idProposition']);//retourne un tableau de toutes les sections d'une proposition

        $this->showView("view.php", [
            "proposition" => $proposition,
            "question"=> $question,
            "sectionsProposition"=> $sectionsProposition,
            "pageTitle" => "Info Proposition",
            "pathBodyView" => "proposition/read.php"
        ]);
    }

}
