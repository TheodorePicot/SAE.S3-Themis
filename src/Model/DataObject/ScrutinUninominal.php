<?php

namespace Themis\Model\DataObject;

use Themis\Model\Repository\DatabaseConnection;

class ScrutinUninominal extends Vote
{
    private int $idQuestion;
    /**
     * @param string $loginVotant
     * @param int $idProposition
     */
    public function __construct(string $loginVotant, int $idProposition, int $idQuestion)
    {
        parent::__construct($loginVotant, $idProposition);
        $this->idQuestion = $idQuestion;
    }


    public function tableFormat(): array
    {
        $temp = parent::tableFormat();
        $temp["idQuestion"] = $this->idQuestion;
        return $temp;
    }

    public static function buildFromForm(array $formArray): ScrutinUninominal
    {
        return new ScrutinUninominal(
            $formArray["loginVotant"],
            $formArray["idProposition"],
            $formArray["idQuestion"]
        );
    }
}
