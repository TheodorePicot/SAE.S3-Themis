<?php

namespace Themis\Model\DataObject;

class Vote extends AbstractDataObject
{
    private string $loginVotant;
    private int $idProposition;
    private int $valeur;

    /**
     * @param string $loginVotant
     * @param int $idProposition
     * @param int $valeur
     */
    public function __construct(string $loginVotant, int $idProposition, int $valeur)
    {
        $this->loginVotant = $loginVotant;
        $this->idProposition = $idProposition;
        $this->valeur = $valeur;
    }


    public function tableFormat(): array
    {
        return [
            "loginVotant" => $this->loginVotant,
            "idProposition" => $this->idProposition,
            "valeur" => $this->valeur
        ];
    }

    /**
     * @return string
     */
    public function getLoginVotant(): string
    {
        return $this->loginVotant;
    }

    /**
     * @return int
     */
    public function getIdProposition(): int
    {
        return $this->idProposition;
    }

    /**
     * @return int
     */
    public function getValeur(): int
    {
        return $this->valeur;
    }

    public static function buildFromForm(array $formArray): Vote
    {
        return new Vote(
            $formArray["loginVotant"],
            $formArray["idProposition"],
            $formArray["valeur"]
        );
    }
}