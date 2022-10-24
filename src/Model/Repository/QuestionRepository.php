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
            'dateDebutProposition',
            'dateFinProposition',
            'dateDebutVote',
            'dateFinVote',
        ];
    }


    protected function build(array $questionArrayFormat): Question
    {
        if (isset($questionArrayFormat['idQuestion'])) { //la question existe déjà
            return new Question($questionArrayFormat['idQuestion'], $questionArrayFormat['titreQuestion'], $questionArrayFormat['dateDebutProposition'], $questionArrayFormat['dateFinProposition'], $questionArrayFormat['dateDebutVote'], $questionArrayFormat['dateFinVote']);
        } else {  //la question n'existe pas (ex:formulaire)
            return new Question((int)null, $questionArrayFormat['titreQuestion'], $questionArrayFormat['dateDebutProposition'], $questionArrayFormat['dateFinProposition'], $questionArrayFormat['dateDebutVote'], $questionArrayFormat['dateFinVote']);
        }
    }
}