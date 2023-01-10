<?php

namespace Themis\Model\DataObject;

abstract class Vote extends AbstractDataObject
{
    private string $loginVotant;
    private int $idProposition;

    /**
     * permet de construire un Vote à partir d'un loginVotant et d'un idProposition
     *
     * @param string $loginVotant
     * @param int $idProposition
     */
    public function __construct(string $loginVotant, int $idProposition)
    {
        $this->loginVotant = $loginVotant;
        $this->idProposition = $idProposition;
    }

    /**
     * permet de retourner toutes les colonnes de la table Vote
     *
     * @return array
     */
    public function tableFormat(): array
    {
        return [
            "loginVotant" => $this->loginVotant,
            "idProposition" => $this->idProposition,
        ];
    }

    /**
     * permet de récupérer le LoginVotant d'un Vote
     *
     * @return string
     */
    public function getLoginVotant(): string
    {
        return $this->loginVotant;
    }

    /**
     * permet de récupérer l'IdProposition d'un Vote
     *
     * @return int
     */
    public function getIdProposition(): int
    {
        return $this->idProposition;
    }

    /**
     * permet de construire un Vote à partir d'une array
     *
     * @return Vote
     */
    public abstract static function buildFromForm(array $formArray): Vote;
}