<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Question;

class QuestionRepository extends AbstractRepository
{
    public function selectAllBySearchValue(string $element): array
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "SELECT * FROM $databaseTable WHERE " . 'LOWER("titreQuestion") LIKE ? OR LOWER("descriptionQuestion") LIKE ?';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array("%" . strtolower($element) . "%", "%" . strtolower($element) . "%"));

        $questions = array();
        foreach ($pdoStatement as $question) {
            $questions[] = $this->build($question);
        }
        return $questions;
    }

    protected function getTableName(): string
    {
        return 'themis."Questions"';
    }

    public function build(array $objectArrayFormat): Question
    {
        if (isset($objectArrayFormat["idQuestion"])) {
            return new Question($objectArrayFormat["idQuestion"],
                $objectArrayFormat["titreQuestion"],
                $objectArrayFormat["descriptionQuestion"],
                $objectArrayFormat["dateDebutProposition"],
                $objectArrayFormat["dateFinProposition"],
                $objectArrayFormat["dateDebutVote"],
                $objectArrayFormat["dateFinVote"],
                $objectArrayFormat["loginOrganisateur"]);
        } else {
            return new Question((int)null,
                $objectArrayFormat["titreQuestion"],
                $objectArrayFormat["descriptionQuestion"],
                $objectArrayFormat["dateDebutProposition"],
                $objectArrayFormat["dateFinProposition"],
                $objectArrayFormat["dateDebutVote"],
                $objectArrayFormat["dateFinVote"],
                $objectArrayFormat["loginOrganisateur"]);
        }
    }

    public function selectAllCurrentlyInWriting(): array
    {
        $databaseTable = $this->getTableName();
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM $databaseTable WHERE CURRENT_TIMESTAMP + interval '1 hour' >= " . '"dateDebutProposition" AND CURRENT_TIMESTAMP + interval ' . "'1 hour'" . '<= "dateFinProposition"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function selectAllCurrentlyInVoting(): array
    {
        $databaseTable = $this->getTableName();
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM $databaseTable WHERE CURRENT_TIMESTAMP + interval '1 hour' >= " . '"dateDebutVote" AND CURRENT_TIMESTAMP + interval ' . "'1 hour'" . '<= "dateFinVote"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function selectAllFinished(): array
    {
        $databaseTable = $this->getTableName();
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM $databaseTable WHERE CURRENT_TIMESTAMP + interval '1 hour' > " . '"dateFinVote"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    protected function getPrimaryKey(): string
    {
        return "idQuestion";
    }

    protected function getColumnNames(): array
    {
        return [
            "titreQuestion",
            "descriptionQuestion",
            "dateDebutProposition",
            "dateFinProposition",
            "dateDebutVote",
            "dateFinVote",
            "loginOrganisateur"
        ];
    }

    protected function getColumnTitle(): string
    {
        return "titreQuestion";
    }

    protected function getOrderColumn(): string
    {
        return '"Questions"."titreQuestion"';
    }
}