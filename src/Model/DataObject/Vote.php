<?php

namespace Themis\Model\DataObject;

abstract class Vote extends AbstractDataObject
{
    private string $loginVotant;
    private int $idProposition;

    /**
     * @param string $loginVotant
     * @param int $idProposition
     */
    public function __construct(string $loginVotant, int $idProposition)
    {
        $this->loginVotant = $loginVotant;
        $this->idProposition = $idProposition;
    }


    public function tableFormat(): array
    {
        return [
            "loginVotant" => $this->loginVotant,
            "idProposition" => $this->idProposition,
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

    public abstract static function buildFromForm(array $formArray): Vote;
}