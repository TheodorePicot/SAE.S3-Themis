<?php

namespace Themis\Controller;

class mainController
{
    public static function createQuestion(): void
    {
        self::showView("view.php", [
            "pageTitle" => "Création d'une question",
            "pathBodyView" => "question/create.php"
        ]);
    }

    private static function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

    public static function saveQuestion(): void
    {
//        $question = new Question($_POST['titreQuestion'],
//                                      $_POST['dateDebutProposition']);
    }

}