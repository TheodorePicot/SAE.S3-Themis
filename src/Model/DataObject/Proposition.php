<?php

namespace Themis\Model\DataObject;

class Proposition extends AbstractDataObject
{

    private int $idProposition;
    private int $idQuestion;
    private string $titreProposition;

    /**
     * @param int $idProposition
     * @param int $idQuestion
     */
    public function __construct(int $idProposition, int $idQuestion, string $titreProposition)
    {
        $this->idProposition = $idProposition;
        $this->idQuestion = $idQuestion;
        $this->titreProposition = $titreProposition;
    }

    public function tableFormat(): array
    {
        if ($this->idProposition == 0) {
            return [
                "idQuestion" => $this->idQuestion,
                "titreProposition" => $this->titreProposition
            ];
        } else {
            return [
                "idProposition" => $this->idProposition,
                "idQuestion" => $this->idQuestion,
                "titreProposition" => $this->titreProposition
            ];
        }
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
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * @return string
     */
    public function getTitreProposition(): string
    {
        return $this->titreProposition;
    }
}