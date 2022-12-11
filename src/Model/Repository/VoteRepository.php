<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Vote;

class VoteRepository extends AbstractRepository
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
    public function build(array $objectArrayFormat): AbstractDataObject
    {
        return new Vote(
            $objectArrayFormat["loginVotant"],
            $objectArrayFormat["idProposition"],
            $objectArrayFormat["valeur"]
        );
    }

    protected function getOrderColumn(): string
    {
        return "loginVotant";
    }

    protected function getPrimaryKey(): string
    {
        return "loginVotant";
    }
}