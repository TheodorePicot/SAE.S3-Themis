<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Proposition;

class PropositionRepository extends AbstractRepository
{
    public function selectByQuestion(int $idQuestion): array
    {
        $sqlQuery = 'SELECT * FROM "Propositions" WHERE "idQuestion" =:idQuestion';

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idQuestion" => $idQuestion
        ];

        $pdoStatement->execute($values);

        $propositions = array();
        foreach ($pdoStatement as $proposition) {
            $propositions[] = $this->build($proposition);
        }

        return $propositions;
    }

    public function selectAllByUser(int $login): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"loginAuteur" = ?';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array($login));

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function build(array $objectArrayFormat): Proposition
    {
        return new Proposition($objectArrayFormat['idProposition'], $objectArrayFormat['idQuestion'], $objectArrayFormat['titreProposition'], $objectArrayFormat['loginAuteur']);
    }

    protected function getTableName(): string
    {
        return 'themis."Propositions"';
    }

    protected function getPrimaryKey(): string
    {
        return "idProposition";
    }

    protected function getColumnNames(): array
    {
        return [
            "idQuestion",
            "titreProposition",
            "loginAuteur"
        ];
    }

    protected function getOrderColumn(): string
    {
        return "titreProposition";
    }
}