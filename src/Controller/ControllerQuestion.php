<?php

namespace Themis\Controller;


use Themis\Model\DataObject\Question;
use Themis\Model\Repository\AbstractRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionRepository;

class ControllerQuestion extends AbstactController
{

    protected function getRepository(): ?AbstractRepository
    {
        return new QuestionRepository();
    }

    protected function getPrimaryKey(): string
    {
        return "idQuestion";
    }

    protected function getControllerName(): string
    {
        return "question";
    }

    protected function getDataObject(): string
    {
        return "Themis\Model\DataObject\Question";
    }

    public function created(): void
    {
            $question = new Question((int)null, $_GET['titreQuestion'], $_GET['dateDebutProposition'], $_GET['dateFinProposition'], $_GET['dateDebutVote'], $_GET['dateFinVote']);

        if ($this->getRepository()->create($question)) {
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

    public function updated(): void
    {
        $question = new Question($_GET['idQuestion'], $_GET['titreQuestion'], $_GET['dateDebutProposition'], $_GET['dateFinProposition'], $_GET['dateDebutVote'], $_GET['dateFinVote']);
        $this->getRepository()->update($question);
        $this->showView("view.php", [
            "questions" => $this->getRepository()->selectAll(),
            "pageTitle" => "Question créée",
            "pathBodyView" => "question/updated.php"
        ]);
    }

    public function read(): void
    {
        $object = $this->getRepository()->select($_GET[$this->getPrimaryKey()]);
        $sections = (new SectionRepository())->selectAllByQuestion($_GET[$this->getPrimaryKey()]);
        $controllerName = $this->getControllerName();
        $this->showView("view.php", [
            "sections" => $sections,
            $controllerName => $object,
            "pageTitle" => "Info $controllerName",
            "pathBodyView" => "$controllerName./read.php"
        ]);
    }
}