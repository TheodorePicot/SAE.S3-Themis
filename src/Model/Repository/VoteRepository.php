<?php

namespace Themis\Model\Repository;

use PDOException;
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
    public function build(array $objectArrayFormat): Vote
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

    public function selectVote($loginVotant, $idProposition): ?Vote
    {
        $sqlQuery = 'SELECT * FROM themis."Votes" 
                    WHERE "loginVotant" = :loginVotant
                    AND "idProposition" = :idProposition';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'loginVotant' => $loginVotant,
            'idProposition' => $idProposition
        );

        try {
            $pdoStatement->execute($values);
        } catch (PDOException $exception) {
            echo $exception->getCode();
//            return $exception->getCode();
        }

        $dataObject = $pdoStatement->fetch();
        if (!$dataObject) return null;

        return $this->build($dataObject);
    }

    public function update(AbstractDataObject $dataObject): void
    {
        $sqlQuery = 'UPDATE "Votes" SET valeur =:valeur WHERE "loginVotant" =:loginVotant AND "idProposition" =:idProposition';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = $dataObject->tableFormat();
        $pdoStatement->execute($values);
    }
}