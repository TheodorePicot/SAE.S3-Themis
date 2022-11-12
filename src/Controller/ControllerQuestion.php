<?php

namespace Themis\Controller;

use Themis\Model\DataObject\Participant;
use Themis\Model\DataObject\Section;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionRepository;
use Themis\Model\Repository\UtilisateurRepository;
use Themis\Model\Repository\VotantRepository;

class ControllerQuestion extends AbstactController
{
    protected function getCreationMessage(): string
    {
        return "Création Question";
    }

    protected function getViewFolderName(): string
    {
        return "question";
    }

    public function create()
    {
        $utilisateurs = (new UtilisateurRepository)->selectAll();
        $this->showView("view.php", [
            "utilisateurs" => $utilisateurs,
            "pageTitle" => $this->getCreationMessage(),
            "pathBodyView" => $this->getViewFolderName() . "/create.php"
        ]);
    }

    public function created(): void
    {
        $question = (new QuestionRepository())->build($_GET);

        if ((new QuestionRepository)->create($question)) {
            $idQuestion = DatabaseConnection::getPdo()->lastInsertId(); // Cette fonction nous permet d'obtenir l'id du dernier objet inséré dans une table.

            $utilisateurs = (new UtilisateurRepository)->selectAll();

            foreach ($_GET["votants"] as $votant) {
                $votantObject = new Participant($votant, $idQuestion);
                (new VotantRepository)->create($votantObject);
            }

            foreach ($_GET["auteurs"] as $auteur) {
                $auteurObject = new Participant($auteur, $idQuestion);
                (new AuteurRepository)->create($auteurObject);
            }

            $sections = (new SectionRepository)->selectAllByQuestion($idQuestion); //retourne un tableau de toutes les sections d'une question
            $question = (new QuestionRepository)->select($idQuestion);
            $message = "Création Question";
            $this->showView("view.php", [
                "utilisateurs" => $utilisateurs,
                "sections" => $sections,
                "question" => $question,
                "message" => $message,
                "pageTitle" => "Création question",
                "pathBodyView" => "question/update.php"
            ]);
        } else {
            $this->showError("Erreur de création de la question");
        }
    }

    public function addSection(): void
    {
        (new SectionRepository)->create(new Section((int)null, $_GET['idQuestion'], "", ""));
        $this->update();
    }

    public function read(): void
    {
        $question = (new QuestionRepository)->select($_GET['idQuestion']);
        $sections = (new SectionRepository)->selectAllByQuestion($_GET['idQuestion']);
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
        $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
        $utilisateurs = (new UtilisateurRepository)->selectAll();
        $message = "Mise à jour question";

        $this->showView("view.php", [
            "utilisateurs" => $utilisateurs,
            "sections" => $sections,
            "question" => $question,
            "message" => $message,
            "pageTitle" => "Mise à jour question",
            "pathBodyView" => "question/update.php"
        ]);
    }

    public function updated(): void
    {
        $question = (new QuestionRepository)->build($_GET);
        (new QuestionRepository)->update($question);

        foreach ((new SectionRepository)->selectAllByQuestion($question->getIdQuestion()) as $section) {
            $updatedSection = new Section($section->getIdSection(), $section->getIdQuestion(), $_GET['titreSection' . $section->getIdSection()], $_GET['descriptionSection' . $section->getIdSection()]);
            (new SectionRepository)->update($updatedSection);
        }

        (new VotantRepository)->delete($question->getIdQuestion());
        (new AuteurRepository)->delete($question->getIdQuestion());

        foreach ($_GET["votants"] as $votant) {
            $votantObject = new Participant($votant, $question->getIdQuestion());
            (new VotantRepository)->create($votantObject);
        }

        foreach ($_GET["auteurs"] as $auteur) {
            $auteurObject = new Participant($auteur, $question->getIdQuestion());
            (new AuteurRepository)->create($auteurObject);
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
        (new SectionRepository)->delete($_GET["idSection"]);
        $this->update();
    }
}