<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Question;

class QuestionRepository extends AbstractRepository
{
    protected function getPrimaryKey(): string
    {
        return '"idQuestion"';
    }

    protected function getTableName(): string
    {
        return 'themis."Questions" t';
    }

    protected function getColumnNames(): array
    {
        return [
            "titreQuestion",
            "dateDebutProposition",
            "dateFinProposition",
            "dateDebutVote",
            "dateFinVote",
        ];
    }

    protected function build(array $questionArrayFormat): Question
    {

        if (isset($questionArrayFormat['idQuestion'])) {
            return new Question($questionArrayFormat['idQuestion'], $questionArrayFormat['titreQuestion'], $questionArrayFormat['dateDebutProposition'], $questionArrayFormat['dateFinProposition'], $questionArrayFormat['dateDebutVote'], $questionArrayFormat['dateFinVote']);
        } else {
            return new Question((int)null, $questionArrayFormat['titreQuestion'], $questionArrayFormat['dateDebutProposition'], $questionArrayFormat['dateFinProposition'], $questionArrayFormat['dateDebutVote'], $questionArrayFormat['dateFinVote']);
        }

    }
}