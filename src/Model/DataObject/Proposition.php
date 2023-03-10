<?php

namespace Themis\Model\DataObject;

class Proposition extends AbstractDataObject
{
    private ?int $idProposition;
    private int $idQuestion;
    private string $titreProposition;
    private string $loginAuteur;
    private int $valeurResultat;
    private array $listeValeur;

    /**
     * Permet de construire une Proposition
     *
     * @param int $idProposition
     * @param int $idQuestion
     * @param string $titreProposition
     * @param string $loginAuteur
     */
    public function __construct(?int $idProposition, int $idQuestion, string $titreProposition, string $loginAuteur)
    {
        $this->idProposition = $idProposition;
        $this->idQuestion = $idQuestion;
        $this->titreProposition = $titreProposition;
        $this->loginAuteur = $loginAuteur;
    }

    /**
     * permet de retourner toutes les colonnes de la table Proposition
     *
     * @return array
     */
    public function tableFormat(): array
    {
        if ($this->idProposition == 0) {
            return [
                "idQuestion" => $this->idQuestion,
                "titreProposition" => $this->titreProposition,
                "loginAuteur" => $this->loginAuteur,
            ];
        } else {
            return [
                "idProposition" => $this->idProposition,
                "idQuestion" => $this->idQuestion,
                "titreProposition" => $this->titreProposition,
                "loginAuteur" => $this->loginAuteur,
            ];
        }
    }

    /**
     * permet de récupérer l'idProposition d'une Proposition
     *
     * @return int
     */
    public function getIdProposition(): int
    {
        return $this->idProposition;
    }

    /**
     * permet de récupérer l'idQuestion d'une Proposition
     *
     * @return int
     */
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * permet de récupérer le titreProposition d'une Proposition
     *
     * @return string
     */
    public function getTitreProposition(): string
    {
        return $this->titreProposition;
    }

    /**
     * permet de récupérer le loginAuteur d'une Proposition
     *
     * @return string
     */
    public function getLoginAuteur(): string
    {
        return $this->loginAuteur;
    }

    /**
     * permet de récupérer la ValeurResultat d'une Proposition
     *
     * @return int
     */
    public function getValeurResultat(): int
    {
        return $this->valeurResultat;
    }

    /**
     * permet de mettre à jour la ValeurResultat d'une Proposition
     *
     * @param int $valeurResultat
     */
    public function setValeurResultat(int $valeurResultat): void
    {
        $this->valeurResultat = $valeurResultat;
    }

    /**
     * @return array
     */
    public function getListeValeur(): array
    {
        return $this->listeValeur;
    }

    /**
     * @param array $listeValeur
     */
    public function setListeValeur(array $listeValeur): void
    {
        $this->listeValeur = $listeValeur;
    }

    /**
     * permet de construire une Proposition à partir d'une array
     *
     * @param array $formArray
     * @return Proposition
     */
    public static function buildFromForm(array $formArray): Proposition
    {
        if (isset($formArray["idProposition"])) {
            return new Proposition(
                $formArray["idProposition"],
                $formArray['idQuestion'],
                $formArray['titreProposition'],
                $formArray['loginAuteur'],
                0
            );
        } else {
            return new Proposition(
                null,
                $formArray['idQuestion'],
                $formArray['titreProposition'],
                $formArray['loginAuteur'],
                0
            );
        }
    }
}