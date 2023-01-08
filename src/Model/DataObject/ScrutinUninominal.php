<?php

namespace Themis\Model\DataObject;

use Themis\Model\Repository\DatabaseConnection;

class ScrutinUninominal extends Vote
{
    /**
     * @param string $loginVotant
     * @param int $idProposition
     */
    public function __construct(string $loginVotant, int $idProposition)
    {
        parent::__construct($loginVotant, $idProposition);
    }


    public function tableFormat(): array
    {
        return parent::tableFormat();
    }

    public static function buildFromForm(array $formArray): ScrutinUninominal
    {
        return new ScrutinUninominal(
            $formArray["loginVotant"],
            $formArray["idProposition"]
        );
    }
}
