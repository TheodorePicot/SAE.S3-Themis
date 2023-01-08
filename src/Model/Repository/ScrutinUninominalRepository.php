<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\ScrutinUninominal;
use Themis\Model\DataObject\Vote;
use Themis\Model\Repository\VotantRepository;

class ScrutinUninominalRepository extends VoteRepository
{
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

    protected function getTableName(): string
    {
        return 'themis."ScrutinUninominal"';
    }

    protected function getColumnNames(): array
    {
        return [
            "loginVotant",
            "idProposition",
        ];
    }

    protected function getOrderColumn(): string
    {
        return "loginVotant";
    }

    protected function getPrimaryKey(): string
    {
        return "loginVotant";
    }


    public function build(array $objectArrayFormat): ScrutinUninominal
    {
        return new ScrutinUninominal($objectArrayFormat["LoginVotant"], $objectArrayFormat["idProposition"]);
    }

    public function getNbVotesProposition(int $idProposition): int
    {
        $sqlQuery = "SELECT COUNT(*) FROM {$this->getTableName()} WHERE \"idProposition\" =:idProposition";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idProposition" => $idProposition];
        $pdoStatement->execute($values);
        return (int) $pdoStatement->fetch()[0];
    }
}
