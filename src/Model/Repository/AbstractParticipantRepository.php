<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Participant;

abstract class AbstractParticipantRepository extends AbstractRepository
{
    abstract public function isParticpantInQuestion(string $login, int $idQuestion): bool;

    protected function getPrimaryKey(): string
    {
        return "idQuestion";
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