<?php

namespace Themis\Controller;

use Themis\Model\Repository\PropositionRepository;

class ControllerVote extends AbstractController
{
    public function vote()
    {
        $propositions = (new PropositionRepository)->selectByQuestion($_GET["idQuestion"]);
        $this->showView("view.php", [
            "propositions" => $propositions,
            "pageTitle" => "Info Proposition",
            "pathBodyView" => "vote/listProposition.php"
        ]);
    }

    public function submitVote()
    {

    }
}