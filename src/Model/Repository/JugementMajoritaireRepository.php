<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\JugementMajoritaire;
use Themis\Model\DataObject\Vote;

class JugementMajoritaireRepository extends VoteRepository
{

    public function build(array $objectArrayFormat): Vote
    {
        return new JugementMajoritaire($objectArrayFormat["loginVotant"], $objectArrayFormat["idProposition"], $objectArrayFormat["valeur"]);    }

    public function selectVote($loginVotant, $idProposition): ?Vote
    {
        $sqlQuery = 'SELECT * FROM ' . $this->getTableName() . '
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
        return 'themis."JugementMajoritaire"';
    }

    protected function getColumnNames(): array
    {
        return [
            "loginVotant",
            "idProposition",
            "valeur"
        ];
    }

    protected function getOrderColumn(): string
    {
        return "loginVotant";
    }

    protected function getPrimaryKey(): string
    {
        return 'login, idProposition';
    }

    public function update(AbstractDataObject $dataObject): void
    {
        $sqlQuery = 'UPDATE "JugementMajoritaire" SET "valeur" =:valeur WHERE "loginVotant" =:loginVotant AND "idProposition" =:idProposition';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = $dataObject->tableFormat();
        $pdoStatement->execute($values);
    }

    public function getVoteProposition(int $idProposition): array
    {
        $sqlQuery = "SELECT COUNT(*) FROM {$this->getTableName()} WHERE \"idProposition\" =:idProposition";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idProposition" => $idProposition];
        $pdoStatement->execute($values);
        return (int) $pdoStatement->fetch()[0];
    }

    public function getNbVotesProposition(int $idProposition): array
    {
        $sqlQuery = "SELECT COUNT(*) FROM {$this->getTableName()} WHERE \"idProposition\" =:idProposition";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = ["idProposition" => $idProposition];
        $pdoStatement->execute($values);
        return (int) $pdoStatement->fetch()[0];
    }
}