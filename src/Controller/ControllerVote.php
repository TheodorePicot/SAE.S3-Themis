<?php

namespace Themis\Controller;

use Themis\Model\Repository\PropositionRepository;
use Themis\Model\Repository\VotantRepository;
use Themis\Model\Repository\VoteRepository;

class ControllerVote extends AbstactController
{
    public function showPropositionsVote()
    {
        $propositions = (new PropositionRepository)->selectByQuestion($_GET['idQuestion']);

        $this->showView("view.php", [
            "propositions" => $propositions,
            "pageTitle" => "Info Proposition",
            "pathBodyView" => "vote/listProposition.php"
        ]);
    }

    public function saveVote() {
        $vote = (new VoteRepository())->build($_GET);

        if ((new VoteRepository())->create($vote)) {
            $this->showView("view.php", [
                "pageTitle" => "Création d'une utilisateur",
                "pathBodyView" => "vote/created.php"
            ]);
        } else {
            $this->showError("Ce login existe déjà");
        }
    }
}