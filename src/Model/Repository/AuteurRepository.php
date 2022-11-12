<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Participant;

class AuteurRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'themis."estAuteur"';
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

    /**
     * @inheritDoc
     */
    public function build(array $objectArrayFormat): AbstractDataObject
    {
        return new Participant($objectArrayFormat["login"], $objectArrayFormat["idQuestion"]);
    }
}