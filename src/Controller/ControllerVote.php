<?php

namespace Themis\Controller;

use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;
use Themis\Model\DataObject\JugementMajoritaire;
use Themis\Model\DataObject\ScrutinUninominal;
use Themis\Model\Repository\JugementMajoritaireRepository;
use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\ScrutinUninominalRepository;
use Themis\Model\Repository\VotantRepository;

class ControllerVote extends AbstractController
{
    /**
     * Affiche la vue nous permettant de voter pour une proposition / les propositions d'une question.
     *
     * Affiche une vue différente par rapport au type de système de vote de la question.
     *
     * @return void
     */
    public function vote(): void
    {
        $question = (new QuestionRepository)->select($_REQUEST["idQuestion"]);
        if ($this->canVote($question)) {
            $propositions = (new PropositionRepository)->selectByQuestion($_REQUEST["idQuestion"]);
            if ($question->getSystemeVote() == "ScrutinUninominal") {
                $this->showView("view.php", [
                    "propositions" => $propositions,
                    "pageTitle" => "Info Proposition",
                    "pathBodyView" => "vote/listPropositionScrutin.php"
                ]);
            } else {
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

    /**
     * Permet de voter
     *
     * Premièrement, cette méthode vérifie le type de vote puis, vérifie si l'utilisateur a déjà voté.
     * Si oui alors elle effectue une mise à jour dans la base de données. Sinon, elle effectue une insertion dans la base de données.
     *
     * @return void
     * @see JugementMajoritaireRepository::votantHasAlreadyVoted()
     * @see ScrutinUninominalRepository::votantHasAlreadyVoted()
     */
    public function submitVote(): void
    {
        $question = (new QuestionRepository)->select($_REQUEST["idQuestion"]);
        if ($this->canVote($question)) {
            if ($question->getSystemeVote() == "ScrutinUninominal") {
                $voteUninominal = new ScrutinUninominal($_REQUEST["loginVotant"], $_REQUEST["idPropositionVote"], $_REQUEST["idQuestion"]);
                if ((new ScrutinUninominalRepository())->votantHasAlreadyVoted($_REQUEST["loginVotant"], $_REQUEST["idQuestion"])) {
                    echo "dans update";
                    (new ScrutinUninominalRepository())->update($voteUninominal);
                } else {
                    (new ScrutinUninominalRepository())->create($voteUninominal);
                    echo "dans create";
                }
            } else {
                foreach ((new PropositionRepository())->selectByQuestion($_REQUEST["idQuestion"]) as $proposition) {
                    $vote = new JugementMajoritaire($_REQUEST["loginVotant"], $proposition->getIdProposition(), $_REQUEST["valueVote{$proposition->getIdProposition()}"]);
                    if ((new JugementMajoritaireRepository())->votantHasAlreadyVoted($_REQUEST["loginVotant"], $proposition->getIdProposition())) {
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

    /**
     * Toutes les verifications concernant l'utilisateur pour savoir s'il peut voter.
     *
     * @param $question
     * @return bool
     */
    private function canVote($question): bool
    {
        return ConnexionUtilisateur::isConnected() && (in_array($question, (new QuestionRepository())->selectAllCurrentlyInVoting()) &&
                (new VotantRepository())->isParticpantInQuestion(ConnexionUtilisateur::getConnectedUserLogin(), $question->getIdQuestion()) &&
                date_create()->format("Y-m-d H:i:s") < $question->getDateFinVote() && date_create()->format("Y-m-d H:i:s") >= $question->getDateDebutVote());
    }

    /**
     * Renvoie le score de chaque vote pour le jugement majoritaire.
     *
     * @param int $idQuestion
     * @return array
     */
    public function scoreMedianeProposition(int $idQuestion): array
    {
        $tab = (new JugementMajoritaireRepository())->getValeurFrequencePropositionsByQuestion($idQuestion);
        $somme = 0;
        $res = [];
        foreach ($tab as $key => $proposition) {
            $nbVoteByProposition = (new JugementMajoritaireRepository())->getNbVote($key);
            foreach ($proposition as $i => $value) {
                $somme += $value;
                if ($somme >= (($nbVoteByProposition % 2 == 0) ? $nbVoteByProposition : ($nbVoteByProposition + 1)) / 2) { // si le nombre de votes est impaire alors on ajoute 1
                    $res[$key] = $i;
                    $somme = 0;
                    break;
                }
            }
        }
        return $res;
    }




}