<?php

namespace Themis\Controller;

use Themis\Model\DataObject\Section;
use Themis\Model\Repository\AbstractRepository;
use Themis\Model\Repository\QuestionRepository;
use Themis\Model\Repository\SectionRepository;

class ControllerSection extends AbstactController
{
    protected function getRepository(): ?AbstractRepository
    {
        return new SectionRepository();
    }

    protected function getPrimaryKey(): string
    {
        return "idSection";
    }

    protected function getControllerName(): string
    {
        return "section";
    }

    protected function getDataObject(): string
    {
        return "Themis\Model\DataObject\Question";
    }

    public function created(): void
    {
        $section = new Section((int)null, $_GET['idQuestion'], "", "");
        $this->getRepository()->create($section);
//        $question = (new QuestionRepository())->select($_GET["idQuestion"]);
//
//        $this->showView();
    }

    public function updated(): void
    {

    }
}