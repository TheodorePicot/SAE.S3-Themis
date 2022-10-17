<?php

namespace Themis\Controller;

use Themis\Model\ModelQuestion;

class mainController
{
    public static function createQuestion(): void
    {
        self::showView("view.php", [
            "pageTitle" => "Création d'une question",
            "pathBodyView" => "question/create.php"
        ]);
    }

    public static function saveQuestion(): void
    {
//        $question = new ModelQuestion($_POST['titreQuestion'],
//                                      $_POST['dateDebutProposition']);
    }

    private static function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView"; // Charge la vue
    }

}