<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Question;

class QuestionRepository extends AbstractRepository
{
    public function selectAllBySearchValue(string $element): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE LOWER(\"titreQuestion\") LIKE ? OR LOWER(\"descriptionQuestion\") LIKE ?";
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
        return new Question($objectArrayFormat["idQuestion"],
            $objectArrayFormat["titreQuestion"],
            $objectArrayFormat["descriptionQuestion"],
            $objectArrayFormat["dateDebutProposition"],
            $objectArrayFormat["dateFinProposition"],
            $objectArrayFormat["dateDebutVote"],
            $objectArrayFormat["dateFinVote"],
            $objectArrayFormat["loginOrganisateur"],
            $objectArrayFormat["systemeVote"]);
    }

    public function selectAllCurrentlyInWriting(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} WHERE CURRENT_TIMESTAMP + interval '1 hour' >= " . '"dateDebutProposition" AND CURRENT_TIMESTAMP + interval ' . "'1 hour'" . '<= "dateFinProposition"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function selectAllCurrentlyInVoting(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} WHERE CURRENT_TIMESTAMP + interval '1 hour' >= " . '"dateDebutVote" AND CURRENT_TIMESTAMP + interval ' . "'1 hour'" . '<= "dateFinVote"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function selectAllFinished(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} WHERE CURRENT_TIMESTAMP + interval '1 hour' > " . '"dateFinVote"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function selectAllByUser(string $login): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"loginOrganisateur" = ?';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array($login));

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function selectAllByIdQuestion(): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} ORDER BY \"idQuestion\" DESC";
        $pdoStatement = DatabaseConnection::getPdo()->query($sqlQuery);

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
            "loginOrganisateur",
            "systemeVote"
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