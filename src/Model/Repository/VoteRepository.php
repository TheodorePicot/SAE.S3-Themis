<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Vote;

abstract class VoteRepository extends AbstractRepository
{
    /**
     * Permet d'obtenir un vote en fonction d'un login et d'une proposition
     *
     * @param $loginVotant
     * @param $idProposition
     * @return Vote|null
     */
    public abstract function selectVote($loginVotant, $idProposition): ?Vote;



}