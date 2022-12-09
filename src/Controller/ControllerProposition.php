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
use Themis\Model\Repository\VotantRepository;

class   ControllerProposition extends AbstractController
{
    public function created(): void
    {
        $proposition = (new PropositionRepository)->build($_GET);
        $this->connectionCheck();
        if ($this->isAuteurInQuestion($proposition->getIdQuestion())
            || $this->isAdmin()) {
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
                $this->redirect("frontController.php?action=read&idQuestion={$proposition->getIdQuestion()}");
            } else if ($creationCode == "23000") {
                (new FlashMessage())->flash("alreadyProposition", "Vous avez déjà créer une proposition", FlashMessage::FLASH_WARNING);
            } else {
                (new FlashMessage())->flash("unknownError", "Erreur (CODE : $creationCode)", FlashMessage::FLASH_DANGER);
            }
        } else {
            (new FlashMessage())->flash("notAuthor", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=readAll");
    }

    public function create(): void
    {
        if ($this->isAuteurInQuestion($_GET["idQuestion"])
            || $this->isAdmin()) {
            $question = (new QuestionRepository)->select($_GET["idQuestion"]);
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

    private function readAuxiliary($question, $proposition) {
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
    }

    public function read(): void
    {
        $proposition = (new PropositionRepository)->select($_GET["idProposition"]);
        $question = (new QuestionRepository)->select($proposition->getIdQuestion());
        if (ConnexionUtilisateur::isConnected()) {
            if ($this->isAuteurInQuestion($_GET["idQuestion"])
                || $this->isCoAuteurInQuestion($_GET["idQuestion"])
                || $this->isAdmin()
                || (in_array($question, (new QuestionRepository())->selectAllCurrentlyInVoting())
                    && (new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $_GET["idQuestion"]))) {
                $this->readAuxiliary($question, $proposition);
            } else {
                (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette proposition", FlashMessage::FLASH_DANGER);
                $this->redirect("frontController.php?action=readAll");
            }
        } else {
            if ((in_array($question, (new QuestionRepository())->selectAllFinished()))) {
                $this->readAuxiliary($question, $proposition);
            } else {
                (new FlashMessage())->flash("readFailed", "Vous n'avez pas accès à cette question", FlashMessage::FLASH_DANGER);
                $this->redirect("frontController.php?action=readAll");
            }
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
        if ($this->isAuteurInQuestion($_GET["idQuestion"])
            || $this->isCoAuteurInQuestion($_GET["idQuestion"])
            || $this->isAdmin()) {
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

            if(isset($_GET["coAuteurs"])) {
                foreach ($_GET["coAuteurs"] as $coAuteur) {
                    $coAuteurObject = new CoAuteur($proposition->getIdProposition(), $coAuteur);
                    (new CoAuteurRepository())->create($coAuteurObject);
                }
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

        if ($this->isAuteurInQuestion($question->getIdQuestion())
            || $this->isCoAuteurInQuestion($question->getIdQuestion())
            || $this->isAdmin()) {
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
        if ($this->isAuteurInQuestion($_GET["idQuestion"])
            || $this->isCoAuteurInQuestion($_GET["idQuestion"])
            || $this->isAdmin()) {
            if ((new PropositionRepository)->delete($_GET["idProposition"])) {
                (new FlashMessage())->flash("deleted", "Votre proposition a bien été supprimée", FlashMessage::FLASH_SUCCESS);
            } else {
                (new FlashMessage())->flash("deleteFailed", "Il y a eu une erreur lors de la suppression de la proposition", FlashMessage::FLASH_DANGER);
            }
            $this->redirect("frontController.php?action=read&idQuestion={$_GET["idQuestion"]}");
        } else {
            (new FlashMessage())->flash("createFailed", "Vous n'avez pas accès cette action", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    private function isAuteurInQuestion(int $idQuestion)
    {
        return (new AuteurRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $idQuestion);
    }

    private function isCoAuteurInQuestion(int $idQuestion)
    {
        return (new CoAuteurRepository())->isCoAuteurInProposition(ConnexionUtilisateur::getConnectedUserLogin(), $idQuestion);

    }
}
