<?php

namespace Themis\Controller;


use Themis\Model\DataObject\Question;
use Themis\Model\Repository\AbstractRepository;
use Themis\Model\Repository\QuestionRepository;

class ControllerQuestion extends AbstactController
{

    protected function getRepository(): ?AbstractRepository
    {
        return new QuestionRepository();
    }

    protected function getPrimaryKey(): string
    {
        return 'idQuestion';
    }

    protected function getControllerName(): string
    {
        return 'question';
    }

    protected function getDataObject(): string
    {
        return "Themis\Model\DataObject\Question";
    }

    public function created(): void
    {
        echo "in created";
            $question = new Question((int)null, $_GET['titreQuestion'], $_GET['dateDebutProposition'], $_GET['dateFinProposition'], $_GET['dateDebutVote'], $_GET['dateFinVote']);

        if ($this->getRepository()->create($question)) {
            echo "successful";
            $questions = $this->getRepository()->selectAll();
            $this->showView("view.php", [
                'questions' => $questions,
                "pageTitle" => "Question créée",
                "pathBodyView" => "question/created.php"
            ]);
        } else {
            $this->showError("Erreur de création de la question");
        }
    }
}