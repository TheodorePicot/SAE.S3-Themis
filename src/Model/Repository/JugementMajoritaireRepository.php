<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Vote;

class JugementMajoritaireRepository extends VoteRepository
{


    public function build(array $objectArrayFormat): Vote
    {
        // TODO: Implement build() method.
    }

    public function selectVote($loginVotant, $idProposition): ?Vote
    {
        // TODO: Implement selectVote() method.
    }
}