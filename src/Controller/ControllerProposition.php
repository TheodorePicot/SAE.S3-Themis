<?php

namespace Themis\Controller;

use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\SectionPropositionRepository;

class ControllerProposition extends AbstactController {
    protected function getCreationMessage(): string
    {
        return "Création d'une proposition";
    }

    protected function getViewFolderName(): string
    {
        return "proposition";
    }


    public function created(): void
    {
        $proposition = (new PropositionRepository())->build($_GET);

        if ((new PropositionRepository)->create($proposition)) {
            $idProposition = DatabaseConnection::getPdo()->lastInsertId(); // Cette fonction nous permet d'obtenir l'id du dernier objet inséré dans une table.

            $sections = (new SectionRepository)->selectAllByQuestion($idProposition); //retourne un tableau de toutes les sections d'une question
            $question = (new QuestionRepository)->select($idProposition);

            foreach ($sections as $section){
                (new SectionPropositionRepository())->build(array('texteProposition'=>'', 'idSection'=>$section->getIdSection()));
            }

            $this->showView("view.php", [
                "sections" => $sections,
                "question" => $question,
                "pageTitle" => "Création d'une question",
                "pathBodyView" => "question/update.php"
            ]);
        } else {
            $this->showError("Erreur de création de la question");
        }
    }
}
