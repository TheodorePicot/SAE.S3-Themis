<?php

namespace Themis\Model\DataObject;

class Question extends AbstractDataObject
{
    private int $idQuestion;
    private string $titreQuestion;
    private string $dateDebutProposition;
    private string $dateFinProposition;
    private string $dateDebutVote;
    private string $dateFinVote;

    /**
     * @param int $idQuestion
     * @param string $titreQuestion
     * @param string $dateDebutProposition
     * @param string $dateFinProposition
     * @param string $dateDebutVote
     * @param string $dateFinVote
     */
    public function __construct(int $idQuestion,
                                string $titreQuestion,
                                string $dateDebutProposition,
                                string $dateFinProposition,
                                string $dateDebutVote,
                                string $dateFinVote)
    {
        $this->idQuestion = $idQuestion;
        $this->titreQuestion = $titreQuestion;
        $this->dateDebutProposition = $dateDebutProposition;
        $this->dateFinProposition = $dateFinProposition;
        $this->dateDebutVote = $dateDebutVote;
        $this->dateFinVote = $dateFinVote;
    }

    public function tableFormatWithPrimaryKey(): array {
        return [
            "idQuestion" => $this->idQuestion,
            "titreQuestion" => $this->titreQuestion,
            "dateDebutProposition" => $this->dateDebutProposition,
            "dateFinProposition" => $this->dateFinProposition,
            "dateDebutVote" => $this->dateDebutVote,
            "dateFinVote" =>$this->dateFinVote
        ];
    }

    public function tableFormatWithoutPrimaryKey(): array
    {
        return [
            "titreQuestion" => $this->titreQuestion,
            "dateDebutProposition" => $this->dateDebutProposition,
            "dateFinProposition" => $this->dateFinProposition,
            "dateDebutVote" => $this->dateDebutVote,
            "dateFinVote" =>$this->dateFinVote
        ];
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
    public function getTitreQuestion(): string
    {
        return $this->titreQuestion;
    }

    /**
     * @return string
     */
    public function getDateDebutProposition(): string
    {
        return $this->dateDebutProposition;
    }

    /**
     * @return string
     */
    public function getDateFinProposition(): string
    {
        return $this->dateFinProposition;
    }

    /**
     * @return string
     */
    public function getDateDebutVote(): string
    {
        return $this->dateDebutVote;
    }

    /**
     * @return string
     */
    public function getDateFinVote(): string
    {
        return $this->dateFinVote;
    }
}
