<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Vote;

abstract class VoteRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'themis."Votes"';
    }

    protected function getColumnNames(): array
    {
        return [
            "loginVotant",
            "idProposition",
            "valeur"
        ];
    }

    /**
     * @inheritDoc
     */
    public abstract function build(array $objectArrayFormat): Vote;

    protected function getOrderColumn(): string
    {
        return "loginVotant";
    }

    protected function getPrimaryKey(): string
    {
        return "loginVotant";
    }

    public abstract function selectVote($loginVotant, $idProposition): ?Vote;

}