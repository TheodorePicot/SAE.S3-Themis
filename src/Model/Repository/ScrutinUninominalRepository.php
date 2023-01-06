<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
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

    public function update(AbstractDataObject $dataObject): void
    {
        $sqlQuery = 'UPDATE "Votes" SET valeur =:valeur WHERE "loginVotant" =:loginVotant AND "idProposition" =:idProposition';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = $dataObject->tableFormat();
        $pdoStatement->execute($values);
    }

    public function build(array $objectArrayFormat): Vote
    {
        // TODO: Implement build() method.
    }
}
