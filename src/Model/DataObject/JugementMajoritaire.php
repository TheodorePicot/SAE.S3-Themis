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
        $temp = parent::tableFormat();
        $temp['valeur'] = $this->valeur;
        return $temp;
    }

    public static function buildFromForm(array $formArray): JugementMajoritaire
    {
        return new JugementMajoritaire(
            $formArray["loginVotant"],
            $formArray["idProposition"],
            $formArray["valeur"]
        );
    }

    /**
     * @return string
     */
    public function getLoginVotant(): string
    {
        return $this->loginVotant;
    }

    /**
     * @param string $loginVotant
     */
    public function setLoginVotant(string $loginVotant): void
    {
        $this->loginVotant = $loginVotant;
    }

    /**
     * @return int
     */
    public function getIdProposition(): int
    {
        return $this->idProposition;
    }

    /**
     * @param int $idProposition
     */
    public function setIdProposition(int $idProposition): void
    {
        $this->idProposition = $idProposition;
    }

    /**
     * @return int
     */
    public function getValeur(): int
    {
        return $this->valeur;
    }

    /**
     * @param int $valeur
     */
    public function setValeur(int $valeur): void
    {
        $this->valeur = $valeur;
    }
}