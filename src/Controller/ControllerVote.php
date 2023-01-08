<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Model\DataObject\JugementMajoritaire;
use Themis\Model\DataObject\ScrutinUninominal;
use Themis\Model\DataObject\Vote;
use Themis\Model\Repository\JugementMajoritaireRepository;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\ScrutinUninominalRepository;
use Themis\Model\Repository\VotantRepository;
use Themis\Model\Repository\VoteRepository;

class ControllerVote extends AbstractController
{
    public function vote()
    {
        $question = (new QuestionRepository)->select($_REQUEST["idQuestion"]);
        if ($this->canVote($question)) {
            $propositions = (new PropositionRepository)->selectByQuestion($_REQUEST["idQuestion"]);
            if ($question->getSystemeVote() == "ScrutinUninominal"){
                $this->showView("view.php", [
                    "propositions" => $propositions,
                    "pageTitle" => "Info Proposition",
                    "pathBodyView" => "vote/listPropositionScrutin.php"
                ]);
            }
            else{
                $this->showView("view.php", [
                    "propositions" => $propositions,
                    "pageTitle" => "Info Proposition",
                    "pathBodyView" => "vote/listPropositionJugement.php"
                ]);
            }

        } else {
            (new FlashMessage())->flash("notAuthor", "Vous n'avez pas accès à cette méthode", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    public function submitVote()
    {
        $question = (new QuestionRepository)->select($_REQUEST["idQuestion"]);
        if ($this->canVote($question)) {
            if ($question->getSystemeVote() == "ScrutinUninominal"){
                $voteUninominal = new ScrutinUninominal($_REQUEST["loginVotant"], $_REQUEST["idPropositionVote"]); // Je sais pas comme trouver l'id de la proposition cochée
                if ((new VotantRepository)->votantHasAlreadyVoted($_REQUEST["loginVotant"], $_REQUEST["idPropositionVote"])) {
                    (new ScrutinUninominalRepository())->update($voteUninominal);
                } else {
                    (new ScrutinUninominalRepository())->create($voteUninominal);
                }
            }
            else{
                foreach ((new PropositionRepository())->selectByQuestion($_REQUEST["idQuestion"]) as $proposition) {
                    $vote = new JugementMajoritaire($_REQUEST["loginVotant"], $proposition->getIdProposition(), $_REQUEST["valueVote{$proposition->getIdProposition()}"]);
                    if ((new VotantRepository)->votantHasAlreadyVoted($_REQUEST["loginVotant"], $proposition->getIdProposition())) {
                        (new JugementMajoritaireRepository)->update($vote);
                    } else {
                        (new JugementMajoritaireRepository)->create($vote);
                    }
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