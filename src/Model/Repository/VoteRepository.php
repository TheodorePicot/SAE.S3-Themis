<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Vote;

abstract class VoteRepository extends AbstractRepository
{
    public abstract function selectVote($loginVotant, $idProposition): ?Vote;



}