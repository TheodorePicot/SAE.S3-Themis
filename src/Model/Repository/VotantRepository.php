<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Participant;

class VotantRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'themis."estVotant"';
    }

    protected function getPrimaryKey(): string
    {
        return '("login", "idQuestion")';
    }

    protected function getColumnNames(): array
    {
        return [
            "login",
            "idQuestion"
        ];
    }

    public function build(array $objectArrayFormat): AbstractDataObject
    {
        return new Participant($objectArrayFormat['Login'], $objectArrayFormat['idQuestion']);
    }

}