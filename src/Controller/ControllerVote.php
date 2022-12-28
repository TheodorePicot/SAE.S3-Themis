<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Model\DataObject\Vote;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\VotantRepository;
use Themis\Model\Repository\VoteRepository;

class ControllerVote extends AbstractController
{
    public function vote()
    {
        $question = (new QuestionRepository)->select($_GET["idQuestion"]);
        if ($this->canVote($question)) {
            $propositions = (new PropositionRepository)->selectByQuestion($_GET["idQuestion"]);

            $this->showView("view.php", [
                "propositions" => $propositions,
                "pageTitle" => "Info Proposition",
                "pathBodyView" => "vote/listProposition.php"
            ]);
        } else {
            (new FlashMessage())->flash("notAuthor", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function submitVote()
    {
        $question = (new QuestionRepository)->select($_POST["idQuestion"]);
        if ($this->canVote($question)) {
            foreach ((new PropositionRepository())->selectByQuestion($_POST["idQuestion"]) as $proposition) {
                $vote = new Vote($_POST["loginVotant"], $proposition->getIdProposition(), $_POST["valueVote{$proposition->getIdProposition()}"]);
                if ((new VotantRepository)->votantHasAlreadyVoted($_POST["loginVotant"], $proposition->getIdProposition())) {
                    (new VoteRepository)->update($vote);
                } else {
                    (new VoteRepository)->create($vote);
                }
            }
            (new FlashMessage())->flash("notAuthor", "Votre vote a été pris en compte", FlashMessage::FLASH_SUCCESS);
        } else {
            (new FlashMessage())->flash("notAuthor", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
        }
        $this->redirect("frontController.php?action=readAll");
    }

    private function canVote($question) {
        return ConnexionUtilisateur::isConnected() && (in_array($question, (new QuestionRepository())->selectAllCurrentlyInVoting()) &&
                (new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $question->getIdQuestion()) &&
                date_create()->format("Y-m-d H:i:s") < $question->getDateFinVote() && date_create()->format("Y-m-d H:i:s") >= $question->getDateDebutVote());
    }
}