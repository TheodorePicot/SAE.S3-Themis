<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Question;

class QuestionRepository extends AbstractRepository
{
    protected function getPrimaryKey(): string
    {
        return 'idQuestion';
    }

    protected function getTableName(): string
    {
        return 'themis."Questions"';
    }

    protected function getColumnNames(): array
    {
        return [
            'titreQuestion',
            'descriptionQuestion',
            'dateDebutProposition',
            'dateFinProposition',
            'dateDebutVote',
            'dateFinVote',
            'nbSections'
        ];
    }

    protected function getColumnTitle(): string
    {
        return 'titreQuestion';
    }

    protected function getOrderColumn(): string
    {
        return '"Questions"."titreQuestion"';
    }


    public function build(array $objectArrayFormat): Question
    {
        if (isset($objectArrayFormat['idQuestion'])) { //la question existe déjà (update)
            return new Question($objectArrayFormat['idQuestion'], $objectArrayFormat['titreQuestion'], $objectArrayFormat["descriptionQuestion"], $objectArrayFormat['dateDebutProposition'], $objectArrayFormat['dateFinProposition'], $objectArrayFormat['dateDebutVote'], $objectArrayFormat['dateFinVote'], $objectArrayFormat['nbSections']);
        } else {  //la question n'existe pas (ex : formulaire) (create)
            return new Question((int)null, $objectArrayFormat['titreQuestion'], $objectArrayFormat["descriptionQuestion"], $objectArrayFormat['dateDebutProposition'], $objectArrayFormat['dateFinProposition'], $objectArrayFormat['dateDebutVote'], $objectArrayFormat['dateFinVote'], $objectArrayFormat['nbSections']);
        }
    }

//    public function getNbSections(int $idQuestion): int
//    {
//        $databaseTable = $this->getTableName();
//        $sqlQuery = 'SELECT "nbSections" FROM ' . $databaseTable . ' WHERE "idQuestion" = ?';
//        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
//        $pdoStatement->execute(array($idQuestion));
//
//        $nbSectionsTab = $pdoStatement->fetch();
//        return (int) $nbSectionsTab['nbSections'];
//    }

    public function search(string $element): array
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


    public function selectAllWrite(): array
    {
        $databaseTable = $this->getTableName();
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM $databaseTable WHERE CAST(NOW() AS DATE) >= " . '"dateDebutProposition" AND CAST(NOW() AS DATE) <= "dateFinProposition"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function selectAllVote(): array
    {
        $databaseTable = $this->getTableName();
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM $databaseTable WHERE CAST(NOW() AS DATE) >= " . '"dateDebutVote" AND CAST(NOW() AS DATE) <= "dateFinVote"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    public function selectAllFinish(): array
    {
        $databaseTable = $this->getTableName();
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM $databaseTable WHERE CAST(NOW() AS DATE) > " . '"dateFinVote"');

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }
}