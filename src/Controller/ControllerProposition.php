<?php

namespace Themis\Controller;

use Themis\Model\Repository\PropositionRepository;

class ControllerProposition extends AbstactController {

    //en cours
    /*
    public function created(): void
    {
        $proposition = (new PropositionRepository())->build($_GET);

        if ((new PropositionRepository)->create($proposition)) {
            $idProposition = DatabaseConnection::getPdo()->lastInsertId(); // Cette fonction nous permet d'obtenir l'id du dernier objet inséré dans une table.

            $sections = (new SectionRepository)->selectAllByQuestion($idQuestion); //retourne un tableau de toutes les sections d'une question
            $question = (new QuestionRepository)->select($idQuestion);

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
    */

    public function create(): void
    {
        $this->showView("view.php", ["pageTitle" => "Création d'une proposition", "pathBodyView" => "proposition/create.php"]);
    }

}
