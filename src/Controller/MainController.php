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

    public static function saveQuestion(): void
    {

    }

}