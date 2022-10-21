<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Question;

class QuestionRepository extends AbstractRepository
{
    protected function getPrimaryKey(): string
    {
        return "idQuestion";
    }

    protected function getTableName(): string
    {
        return "Questions";
    }

    protected function build(array $questionArrayFormat): Question
    {
        return new Question($questionArrayFormat['titreQuestion'], $questionArrayFormat['dateDebutProposition'], $questionArrayFormat['dateFinProposition'], $questionArrayFormat['dateDebutVote'], $questionArrayFormat['dateFinVote']);
    }
}