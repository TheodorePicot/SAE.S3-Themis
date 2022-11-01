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

    public function getNbSections(string $idQuestion): int {
        $sqlQuery = 'SELECT "nbSections" FROM "Questions" WHERE "idQuestion" = ' . $idQuestion;
        $pdoStatement = DatabaseConnection::getPdo()->query($sqlQuery);
        $nbSectionTab = $pdoStatement->fetch();
        return (int) $nbSectionTab['nbSections'];
    }


    protected function build(array $questionArrayFormat): Question
    {
        if (isset($questionArrayFormat['idQuestion'])) { //la question existe déjà
            return new Question($questionArrayFormat['idQuestion'], $questionArrayFormat['titreQuestion'], $questionArrayFormat["descriptionQuestion"], $questionArrayFormat['dateDebutProposition'], $questionArrayFormat['dateFinProposition'], $questionArrayFormat['dateDebutVote'], $questionArrayFormat['dateFinVote']);
        } else {  //la question n'existe pas (ex : formulaire)
            return new Question((int)null,$questionArrayFormat['titreQuestion'],$questionArrayFormat["descriptionQuestion"] , $questionArrayFormat['dateDebutProposition'], $questionArrayFormat['dateFinProposition'], $questionArrayFormat['dateDebutVote'], $questionArrayFormat['dateFinVote']);
        }
    }
}