<?php

namespace Themis\Model\DataObject;

class Proposition extends AbstractDataObject
{
    private int $idProposition;
    private int $idQuestion;
    private string $titreProposition;
    private string $loginAuteur;

    /**
     * @param int $idProposition
     * @param int $idQuestion
     * @param string $titreProposition
     * @param string $loginAuteur
     */
    public function __construct(int $idProposition, int $idQuestion, string $titreProposition, string $loginAuteur)
    {
        $this->idProposition = $idProposition;
        $this->idQuestion = $idQuestion;
        $this->titreProposition = $titreProposition;
        $this->loginAuteur = $loginAuteur;
    }

    public function tableFormat(): array
    {
        if ($this->idProposition == 0) {
            return [
                "idQuestion" => $this->idQuestion,
                "titreProposition" => $this->titreProposition,
                "loginAuteur" => $this->loginAuteur
            ];
        } else {
            return [
                "idProposition" => $this->idProposition,
                "idQuestion" => $this->idQuestion,
                "titreProposition" => $this->titreProposition,
                "loginAuteur" => $this->loginAuteur
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

    /**
     * @return string
     */
    public function getLoginAuteur(): string
    {
        return $this->loginAuteur;
    }

    public static function buildFromForm(array $formArray): AbstractDataObject
    {
        return new Proposition((int)null, $formArray['idQuestion'], $formArray['titreProposition'], $formArray['loginAuteur']);
    }
}