<?php

namespace Themis\Controller;

use Themis\Model\Repository\UtilisateurRepository;

class ControllerUtilisateur extends AbstactController
{
    protected function getCreationMessage(): string
    {
        return "Inscription";
    }

    protected function getViewFolderName(): string
    {
        return "utilisateur";
    }

    public function created()
    {
        $question = (new UtilisateurRepository())->build($_GET);

        if ((new QuestionRepository)->create($question)) {
            $idQuestion = DatabaseConnection::getPdo()->lastInsertId(); // Cette fonction nous permet d'obtenir l'id du dernier objet inséré dans une table.

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
}