<?php

namespace Themis\Model\DataObject;

class Question extends AbstractDataObject
{
    private int $idQuestion;
    private string $titreQuestion;
    private string $descriptionQuestion;
    private string $dateDebutProposition;
    private string $dateFinProposition;
    private string $dateDebutVote;
    private string $dateFinVote;

    /**
     * @param int $idQuestion
     * @param string $titreQuestion
     * @param string $descriptionQuestion
     * @param string $dateDebutProposition
     * @param string $dateFinProposition
     * @param string $dateDebutVote
     * @param string $dateFinVote
     */
    public function __construct(int    $idQuestion,
                                string $titreQuestion,
                                string $descriptionQuestion,
                                string $dateDebutProposition,
                                string $dateFinProposition,
                                string $dateDebutVote,
                                string $dateFinVote)
    {
        $this->idQuestion = $idQuestion;
        $this->titreQuestion = $titreQuestion;
        $this->descriptionQuestion = $descriptionQuestion;
        $this->dateDebutProposition = $dateDebutProposition;
        $this->dateFinProposition = $dateFinProposition;
        $this->dateDebutVote = $dateDebutVote;
        $this->dateFinVote = $dateFinVote;
    }

    public function tableFormat(): array
    {
        if($this->idQuestion == 0) {
            return [
                "titreQuestion" => $this->titreQuestion,
                "descriptionQuestion" => $this->descriptionQuestion,
                "dateDebutProposition" => $this->dateDebutProposition,
                "dateFinProposition" => $this->dateFinProposition,
                "dateDebutVote" => $this->dateDebutVote,
                "dateFinVote" => $this->dateFinVote
            ];
        } else {
            return [
                "idQuestion" => $this->idQuestion,
                "titreQuestion" => $this->titreQuestion,
                "descriptionQuestion" => $this->descriptionQuestion,
                "dateDebutProposition" => $this->dateDebutProposition,
                "dateFinProposition" => $this->dateFinProposition,
                "dateDebutVote" => $this->dateDebutVote,
                "dateFinVote" => $this->dateFinVote
            ];
        }
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

    /**
     * @return string
     */
    public function getDescriptionQuestion(): string
    {
        return $this->descriptionQuestion;
    }

    public function getShortDescriptionQuestion(): string
    {
        $tmp = substr($this->descriptionQuestion, 0, 120);
        $tmp .= "...";
        return $tmp;
    }
}
