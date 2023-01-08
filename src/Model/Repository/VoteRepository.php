<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Vote;

abstract class VoteRepository extends AbstractRepository
{
    public abstract function selectVote($loginVotant, $idProposition): ?Vote;

    public function votantHasAlreadyVoted(string $loginVotant, int $idProposition): bool
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} 
                    WHERE \"loginVotant\" = :loginVotant
                    AND \"idProposition\" = :idProposition";
//        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'loginVotant' => $loginVotant,
            'idProposition' => $idProposition
        );

        try {
            $pdoStatement->execute($values);
        } catch (PDOException $exception) {
            echo $exception->getCode();
            return $exception->getCode();
        }
        $dataObject = $pdoStatement->fetch();
//        echo $dataObject[0];
        if ($dataObject != false) {
            return $dataObject[0] == $loginVotant;
        }
        return false;
    }

}