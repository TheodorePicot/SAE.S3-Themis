<?php

namespace Themis\Model\Repository;

use Exception;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Vote;

class VoteRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'themis."Votes"';
    }

    protected function getPrimaryKey(): string
    {
        return "idProposition";
    }

    protected function getColumnNames(): array
    {
        return [
            "login",
            "idProposition"
        ];
    }

    /**
     * @throws Exception
     */
    protected function getOrderColumn(): string
    {
        // TODO: Implement getOrderColumn() method.
        throw new Exception('Method not yet implemented', 100);
    }


    /**
     * @inheritDoc
     */
    public function build(array $objectArrayFormat): AbstractDataObject
    {
        return new Vote($objectArrayFormat['login'], $objectArrayFormat['idProposition']);
    }
}