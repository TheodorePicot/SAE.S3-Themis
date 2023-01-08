<?php

namespace Themis\Model\DataObject;

class JugementMajoritaire extends Vote
{

    private int $valeur;

    /**
     * @param string $loginVotant
     * @param int $idProposition
     */
    public function __construct(string $loginVotant, int $idProposition, int $valeur)
    {
        parent::__construct($loginVotant, $idProposition);
        $this->valeur = $valeur;
    }


    public function tableFormat(): array
    {
        return parent::tableFormat();
    }

    public static function buildFromForm(array $formArray): JugementMajoritaire
    {
        return new JugementMajoritaire(
            $formArray["loginVotant"],
            $formArray["idProposition"],
            $formArray["valeur"]
        );
    }
}