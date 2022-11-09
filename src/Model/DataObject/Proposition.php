<?php

namespace Themis\Model\DataObject;

class Proposition extends AbstractDataObject {

    private int $idProposition;
    private int $idQuestion;

    /**
     * @param int $idProposition
     * @param int $idQuestion
     */
    public function __construct(int $idProposition, int $idQuestion)
    {
        $this->idProposition = $idProposition;
        $this->idQuestion = $idQuestion;
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

    public function tableFormatWithoutPrimaryKey(): array
    {
        // TODO: Implement tableFormatWithoutPrimaryKey() method.
        return [
            "idProposition" => $this->idProposition,
            "idQuestion" => $this->idQuestion
        ];
    }

    public function tableFormatWithPrimaryKey(): array
    {
        // TODO: Implement tableFormatWithPrimaryKey() method.
        return [
            "idQuestion" => $this->idQuestion
        ];
    }
}