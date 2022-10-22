<?php

namespace Themis\Controller;


use Themis\Model\Repository\QuestionRepository;

class ControllerQuestion extends AbstactController
{
    public static function read(): void {
        $question = (new QuestionRepository())->select($_GET['idQuestion']);
        echo $_GET['idQuestion'];
        self::showView("view.php", [
            "question" => $question,
            "pageTitle" => "Info question",
            "pathBodyView" => "question/read.php"
        ]);


    }

    public static function readAll(): void {
        $questions = (new QuestionRepository())->selectAll();
        self::showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Info question",
            "pathBodyView" => "question/list.php"
        ]);
    }

    public static function create(): void
    {
        self::showView("view.php", [
            "pageTitle" => "Création d'une question",
            "pathBodyView" => "question/create.php"
        ]);
    }

    public static function created(): void
    {

    }
}