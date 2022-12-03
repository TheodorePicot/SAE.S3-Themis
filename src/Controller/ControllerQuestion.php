<?php

namespace Themis\Controller;

use Themis\Model\DataObject\Participant;
use Themis\Model\DataObject\Section;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionRepository;
use Themis\Model\Repository\UtilisateurRepository;
use Themis\Model\Repository\VotantRepository;

class ControllerQuestion extends AbstactController
{
    public function create(): void
    {
        $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();
        $this->showView("view.php", [
            "utilisateurs" => $utilisateurs,
            "pageTitle" => "Création Question",
            "pathBodyView" => "question/create.php"
        ]);
    }

    public function created(): void
    {
        $question = (new QuestionRepository)->build($_GET);

        if ((new QuestionRepository)->create($question)) {
            $idQuestion = DatabaseConnection::getPdo()->lastInsertId(); // Cette fonction nous permet d'obtenir l'id du dernier objet inséré dans une table.

            foreach ($_GET["votants"] as $votant) {
                $votantObject = new Participant($votant, $idQuestion);
                (new VotantRepository)->create($votantObject);
            }

            foreach ($_GET["auteurs"] as $auteur) {
                $auteurObject = new Participant($auteur, $idQuestion);
                (new AuteurRepository)->create($auteurObject);
            }

            $question = (new QuestionRepository)->select($idQuestion);

            header("Location: frontController.php?action=update&idQuestion=" . $question->getIdQuestion());
        } else {
            $this->showError("Erreur de création de la question");
        }
    }

    public function addSection(): void
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

        (new SectionRepository)->create(new Section((int)null, $_GET['idQuestion'], "", ""));

        header("Location: frontController.php?action=update&idQuestion=" . $_GET['idQuestion']);
    }

    public function read(): void
    {
        $question = (new QuestionRepository)->select($_GET['idQuestion']);
        $sections = (new SectionRepository)->selectAllByQuestion($_GET['idQuestion']);
        $votants = (new VotantRepository)->selectAllByQuestion($_GET['idQuestion']);
        $auteurs = (new AuteurRepository)->selectAllByQuestion($_GET['idQuestion']);
        $propositions = (new PropositionRepository)->selectByQuestion($_GET['idQuestion']);

        $this->showView("view.php", [
            "propositions" => $propositions,
            "sections" => $sections,
            "question" => $question,
            "votants" => $votants,
            "auteurs" => $auteurs,
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

    public function readAllByAlphabeticalOrder()
    {
        $questions = (new QuestionRepository)->selectAllOrdered();
        $this->showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Questions",
            "pathBodyView" => "question/list.php"
        ]);
    }

    public function readAllWrite(): void
    {
        $questions = (new QuestionRepository)->selectAllWrite();
        $this->showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Questions",
            "pathBodyView" => "question/list.php"
        ]);
    }

    public function readAllVote(): void
    {
        $questions = (new QuestionRepository)->selectAllVote();
        $this->showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Questions",
            "pathBodyView" => "question/list.php"
        ]);
    }

    public function readAllFinish(): void
    {
        $questions = (new QuestionRepository)->selectAllFinish();
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
        (new SectionRepository)->delete($_GET["lastIdSection"]);
        $this->update();
    }

    public function search(): void
    {
        $questions = (new QuestionRepository())->search($_GET['element']);
        $this->showView("view.php", [
            "questions" => $questions,
            "pageTitle" => "Questions recherchées",
            "pathBodyView" => "question/list.php"
        ]);
    }

    public function vote(): void
    {

    }
}