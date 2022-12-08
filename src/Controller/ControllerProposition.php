<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Model\DataObject\CoAuteur;
use Themis\Model\Repository\AuteurRepository;
use Themis\Model\Repository\CoAuteurRepository;
use Themis\Model\Repository\DatabaseConnection;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionPropositionRepository;
use Themis\Model\Repository\SectionRepository;
use Themis\Model\Repository\UtilisateurRepository;

class ControllerProposition extends AbstractController
{
    public function created(): void
    {
        $proposition = (new PropositionRepository)->build($_GET);
        $creationCode = (new PropositionRepository)->create($proposition);
        if ($creationCode == "") {
            $idProposition = DatabaseConnection::getPdo()->lastInsertId();

            $sections = (new SectionRepository)->selectAllByQuestion($proposition->getIdQuestion());
            foreach ($sections as $section) {
                $sectionProposition = (new SectionPropositionRepository)->build([
                    "texteProposition" => $_GET["descriptionSectionProposition{$section->getIdSection()}"],
                    "idSection" => $section->getIdSection(),
                    "idProposition" => $idProposition
                ]);
                (new SectionPropositionRepository)->create($sectionProposition);
            }
            if (isset($_GET["coAuteurs"])) {
                foreach ($_GET["coAuteurs"] as $coAuteur) {
                    $coAuteurObject = new CoAuteur($idProposition, $coAuteur);
                    (new CoAuteurRepository)->create($coAuteurObject);
                }
            }
            (new FlashMessage())->flash("created", "Votre proposition a été créée", FlashMessage::FLASH_SUCCESS);
        } else if ($creationCode == "23503") {
            (new FlashMessage())->flash("notAuthor", "Vous n'êtes pas auteur de cette question", FlashMessage::FLASH_DANGER);
        } else if ($creationCode == "23000") {
            (new FlashMessage())->flash("alreadyProposition", "Vous avez déjà créer une proposition", FlashMessage::FLASH_WARNING);
        } else {
            (new FlashMessage())->flash("created", "Erreur (CODE : $creationCode)", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=read&idQuestion={$proposition->getIdQuestion()}");
    }

    public function create(): void
    {
        if ((new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"])) {
            $question = (new QuestionRepository)->select($_GET['idQuestion']);
            $sections = (new SectionRepository)->selectAllByQuestion($_GET["idQuestion"]);
            $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();
            $this->showView("view.php", [
                "utilisateurs" => $utilisateurs,
                "sections" => $sections,
                "question" => $question,
                "pageTitle" => "Création Proposition",
                "pathBodyView" => "proposition/create.php"
            ]);
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function read(): void
    {
        $this->connectionCheck();
        if ((new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"])) { // TODO faire co-ateurs
            $proposition = (new PropositionRepository)->select($_GET["idProposition"]);
            $question = (new QuestionRepository)->select($proposition->getIdQuestion());
            $sections = (new SectionRepository())->selectAllByQuestion($question->getIdQuestion());
            $coAuteurs = (new CoAuteurRepository())->selectAllByProposition($proposition->getIdProposition());

            $this->showView("view.php", [
                "coAuteurs" => $coAuteurs,
                "proposition" => $proposition,
                "question" => $question,
                "sections" => $sections,
                "pageTitle" => "Info Proposition",
                "pathBodyView" => "proposition/read.php"
            ]);
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function readByQuestion(): void
    {
        $propositions = (new PropositionRepository)->selectByQuestion($_GET["idQuestion"]);

        $this->showView("view.php", [
            "propositions" => $propositions,
            "pageTitle" => "Info Proposition",
            "pathBodyView" => "proposition/listByQuestion.php"
        ]);
    }

    public function updated(): void
    {
        if ((new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"])) { // TODO Faire co-ateurs
            $proposition = (new PropositionRepository)->build($_GET);
            (new PropositionRepository)->update($proposition);
            $sections = (new SectionRepository)->selectAllByQuestion($proposition->getIdQuestion());

            foreach ($sections as $section) {
                $sectionsPropositionOld = (new SectionPropositionRepository())->selectByPropositionAndSection($proposition->getIdProposition(), $section->getIdSection());
                $sectionPropositionNew = (new SectionPropositionRepository)->build([
                    "texteProposition" => $_GET["descriptionSectionProposition{$section->getIdSection()}"],
                    "idSection" => $section->getIdSection(),
                    "idProposition" => $proposition->getIdProposition(),
                    "idSectionProposition" => $sectionsPropositionOld->getIdSectionProposition()
                ]);
                (new SectionPropositionRepository)->update($sectionPropositionNew);
            }

            (new CoAuteurRepository())->delete($proposition->getIdProposition());

            foreach ($_GET["coAuteurs"] as $coAuteur) {
                $coAuteurObject = new CoAuteur($proposition->getIdProposition(), $coAuteur);
                (new CoAuteurRepository())->create($coAuteurObject);
            }

            (new FlashMessage())->flash("created", "Votre proposition a été mise à jour", FlashMessage::FLASH_SUCCESS);
            $this->redirect("frontController.php?action=read&idQuestion={$proposition->getIdQuestion()}");
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function update(): void
    {
        $proposition = (new PropositionRepository)->select($_GET["idProposition"]);
        $question = (new QuestionRepository)->select($proposition->getIdQuestion());

        if ((new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $question->getIdQuestion())) { // TODO Faire co-ateurs
            $sections = (new SectionRepository())->selectAllByQuestion($question->getIdQuestion());
            $utilisateurs = (new UtilisateurRepository)->selectAllOrdered();

            $this->showView("view.php", [
                "utilisateurs" => $utilisateurs,
                "proposition" => $proposition,
                "question" => $question,
                "sections" => $sections,
                "pageTitle" => "Info Proposition",
                "pathBodyView" => "proposition/update.php"
            ]);
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function delete(): void
    {
        if (!(new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"])) {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        } else {
            if ((new PropositionRepository)->delete($_GET["idProposition"])) {
                (new FlashMessage())->flash("deleted", "Votre proposition a bien été supprimée", FlashMessage::FLASH_SUCCESS);
            } else {
                (new FlashMessage())->flash("deleteFailed", "Il y a eu une erreur lors de la suppression de la proposition", FlashMessage::FLASH_DANGER);
            }
            $this->redirect("frontController.php?action=read&idQuestion={$_GET["idQuestion"]}");
        }
    }
}
