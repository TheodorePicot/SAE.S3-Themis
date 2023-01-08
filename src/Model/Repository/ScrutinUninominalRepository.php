<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\ScrutinUninominal;
use Themis\Model\DataObject\Vote;
use Themis\Model\Repository\VotantRepository;

class ScrutinUninominalRepository extends VoteRepository
{
    public function selectVote($loginVotant, $idQuestion): ?Vote
    {
        $sqlQuery = 'SELECT * FROM themis."ScrutinUninominal" 
                    WHERE "loginVotant" = :loginVotant
                    AND "idQuestion" = :idQuestion';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'loginVotant' => $loginVotant,
            'idProposition' => $idQuestion
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
            "idQuestion"
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
        return new ScrutinUninominal($objectArrayFormat["LoginVotant"], $objectArrayFormat["idProposition"], $objectArrayFormat["idQuestion"]);
    }

    public function getNbVotesProposition(int $idProposition): int
    {
        $sqlQuery = "SELECT COUNT(*) FROM {$this->getTableName()} WHERE \"idProposition\" =:idProposition";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idProposition" => $idProposition];
        $pdoStatement->execute($values);
        return (int) $pdoStatement->fetch()[0];
    }

    public function update(AbstractDataObject $dataObject): void
    {
        $sqlQuery = 'UPDATE themis."ScrutinUninominal" SET "idProposition" =:idProposition WHERE "loginVotant" =:loginVotant AND "idQuestion" =:idQuestion';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = $dataObject->tableFormat();
        var_dump($values);
        echo $sqlQuery;
        $pdoStatement->execute($values);
    }

    public function votantHasAlreadyVotedScrutin(string $loginVotant, int $idQuestion): bool
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} 
                    WHERE \"idQuestion\" =:idQuestion
                    AND \"loginVotant\" =:loginVotant";
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'loginVotant' => $loginVotant,
            'idQuestion' => $idQuestion
        );

        $pdoStatement->execute($values);

        return $pdoStatement->rowCount() > 0;
    }

    public function votantHasAlreadyVotedForPropositionScrutin(string $loginVotant, int $idProposition): bool
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

        $pdoStatement->execute($values);

        return $pdoStatement->rowCount() > 0;
    }
}
