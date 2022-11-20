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
        ];
    }

    protected function getColumnTitle(): string
    {
        return 'titreQuestion';
    }

    public function build(array $objectArrayFormat): Question
    {
        if (isset($objectArrayFormat['idQuestion'])) { //la question existe déjà (update)
            return new Question($objectArrayFormat['idQuestion'], $objectArrayFormat['titreQuestion'], $objectArrayFormat["descriptionQuestion"], $objectArrayFormat['dateDebutProposition'], $objectArrayFormat['dateFinProposition'], $objectArrayFormat['dateDebutVote'], $objectArrayFormat['dateFinVote']);
        } else {  //la question n'existe pas (ex : formulaire) (create)
            return new Question((int)null, $objectArrayFormat['titreQuestion'], $objectArrayFormat["descriptionQuestion"], $objectArrayFormat['dateDebutProposition'], $objectArrayFormat['dateFinProposition'], $objectArrayFormat['dateDebutVote'], $objectArrayFormat['dateFinVote']);
        }
    }

    public function search(string $element): array
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "SELECT * FROM $databaseTable WHERE " . '"titreQuestion" LIKE ? OR "descriptionQuestion" LIKE ?';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array("%" . $element . "%", "%" . $element . "%"));

        $questions = array();
        foreach ($pdoStatement as $question) {
            $questions[] = $this->build($question);
        }

        return $questions;
    }
}