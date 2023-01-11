<?php

namespace Themis\Model\DataObject;

use Themis\Model\Repository\DatabaseConnection;

class ScrutinUninominal extends Vote
{
    private int $idQuestion;
    /**
     * Permet de construire un Vote à partir d'un loginVotant, d'un idProposition
     *
     * @param string $loginVotant
     * @param int $idProposition
     * @param int $idQuestion
     */
    public function __construct(string $loginVotant, int $idProposition, int $idQuestion)
    {
        parent::__construct($loginVotant, $idProposition);
        $this->idQuestion = $idQuestion;
    }

    /**
     * Permet de retourner toutes les colonnes de la table Vote
     *
     * @return array
     */
    public function tableFormat(): array
    {
        $temp = parent::tableFormat();
        $temp["idQuestion"] = $this->idQuestion;
        return $temp;
    }

    /**
     * Permet de construire un Vote à partir d'une array
     *
     * @param array $formArray
     * @return Vote
     */
    public static function buildFromForm(array $formArray): ScrutinUninominal
    {
        return new ScrutinUninominal(
            $formArray["loginVotant"],
            $formArray["idProposition"],
            $formArray["idQuestion"]
        );
    }
}
