<?php

namespace Themis\Controller;

use Themis\Model\DataObject\Section;
use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionRepository;

class ControllerQuestion extends AbstactController
{
    public function created(): void
    {
        $question = (new QuestionRepository())->build($_GET);

        if ((new QuestionRepository)->create($question)) {
            $idQuestion = DatabaseConnection::getPdo()->lastInsertId(); // Cette fonction nous permet d'obtenir l'id du dernier objet inséré dans une table.
            $section = new Section((int)null, $idQuestion, "", "");

            for ($i = 0; $i < $_GET["nbSections"]; $i++) {
                (new SectionRepository())->create($section);
            }

            $sections = (new SectionRepository())->selectAllByQuestion($idQuestion);
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

    public function create(): void
    {
        $this->showView("view.php", [
            "pageTitle" => "Création d'une question",
            "pathBodyView" => "question/create.php"
        ]);
    }

    public function addSection(): void
    {
        (new SectionRepository())->create(new Section((int)null, $_GET['idQuestion'], "", ""));
        $this->update();
    }

    public function read(): void
    {
        $question = (new QuestionRepository)->select($_GET['idQuestion']);
        $sections = (new SectionRepository())->selectAllByQuestion($_GET['idQuestion']);
        $this->showView("view.php", [
            "sections" => $sections,
            "question" => $question,
            "pageTitle" => "Info question",
            "pathBodyView" => "question/read.php"
        ]);
    }

    public function readAll(): void
    {
        $questions = (new QuestionRepository)->selectAll();
        $this->showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Questions",
            "pathBodyView" => "question/list.php"
        ]);
    }

    public function update(): void
    {
        $sections = (new SectionRepository())->selectAllByQuestion($_GET["idQuestion"]);
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
        $this->showView("view.php", [
            "sections" => $sections,
            "question" => $question,
            "pageTitle" => "Mise à jour question",
            "pathBodyView" => "question/update.php"
        ]);
    }

    public function updated(): void
    {
        $question = (new QuestionRepository())->build($_GET);
        (new QuestionRepository)->update($question);

        foreach ((new SectionRepository)->selectAllByQuestion($question->getIdQuestion()) as $section) {
            $updatedSection = new Section($section->getIdSection(), $section->getIdQuestion(), $_GET['titreSection' . $section->getIdSection()], $_GET['descriptionSection' . $section->getIdSection()]);
            (new SectionRepository)->update($updatedSection);
        }

        $this->showView("view.php", [
            "questions" => (new QuestionRepository)->selectAll(),
            "pageTitle" => "Question mise à jour",
            "pathBodyView" => "question/updated.php"
        ]);
    }

    public function delete(): void
    {
        if ((new QuestionRepository)->delete($_GET['idQuestion'])) {
            $questions = (new QuestionRepository)->selectAll();
            $this->showView("view.php", [
                "questions" => $questions,
                "pageTitle" => "Suppression",
                "pathBodyView" => "question/deleted.php"
            ]);
        }
    }

    public function deleteLastSection(): void
    {
        (new SectionRepository())->delete($_GET["idSection"]);
        $this->update();
    }
}