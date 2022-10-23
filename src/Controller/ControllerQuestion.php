<?php

namespace Themis\Controller;


use Themis\Model\Repository\AbstractRepository;
use Themis\Model\Repository\QuestionRepository;

class ControllerQuestion extends AbstactController
{

    protected function getRepository(): ?AbstractRepository
    {
        return new QuestionRepository();
    }

    protected function getPrimaryKey(): string
    {
        return 'idQuestion';
    }

    protected function getControllerName(): string
    {
        return 'question';
    }

    protected function getDataObject(): string
    {
        return "Themis\Model\DataObject\Question";
    }

    public function readAll(): void
    {
        parent::readAll(); // TODO: Change the autogenerated stub
    }
}