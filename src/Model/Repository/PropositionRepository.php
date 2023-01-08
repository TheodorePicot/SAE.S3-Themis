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

    public function selectAllByUser(string $login): array
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

    public function selectAllByQuestionsOrderedByVoteValueScrutin(int $idQuestion): array
    {
        $sqlQuery = "SELECT p.\"idProposition\" FROM \"Propositions\" p JOIN themis.\"ScrutinUninominal\" s ON p.\"idProposition\" = s.\"idProposition\" WHERE \"idQuestion\" =:idQuestion GROUP BY p.\"idProposition\" ORDER BY COUNT(*) DESC";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idQuestion" => $idQuestion
        ];

        $pdoStatement->execute($values);

        $propositions = array();
        foreach ($pdoStatement as $proposition) {
            $propositions[] = $this->select($proposition[0]);
        }

        return $propositions;
    }

    public function aPropositionIsInQuestion(int $idQuestion): bool
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()}" . ' WHERE "idQuestion" =:idQuestion';

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idQuestion" => $idQuestion
        ];

        $pdoStatement->execute($values);
        return $pdoStatement->rowCount() > 0;
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
            "loginAuteur",
        ];
    }

    protected function getOrderColumn(): string
    {
        return "titreProposition";
    }
}