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

    public function build(array $objectArrayFormat): Question
    {
        if (isset($objectArrayFormat['idQuestion'])) { //la question existe déjà
            return new Question($objectArrayFormat['idQuestion'], $objectArrayFormat['titreQuestion'], $objectArrayFormat["descriptionQuestion"], $objectArrayFormat['dateDebutProposition'], $objectArrayFormat['dateFinProposition'], $objectArrayFormat['dateDebutVote'], $objectArrayFormat['dateFinVote']);
        } else {  //la question n'existe pas (ex : formulaire)
            return new Question((int)null,$objectArrayFormat['titreQuestion'],$objectArrayFormat["descriptionQuestion"] , $objectArrayFormat['dateDebutProposition'], $objectArrayFormat['dateFinProposition'], $objectArrayFormat['dateDebutVote'], $objectArrayFormat['dateFinVote']);
        }
    }
}