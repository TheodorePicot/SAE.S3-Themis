<?php

namespace Themis\Model\DataObject;

class Question extends AbstractDataObject
{
    private int $idQuestion;
    private string $titreQuestion;
    private string $dateDebutPropostion;
    private string $dateFinProposition;
    private string $dateDebutVote;
    private string $dateFinVote;
    private string $mailOrganisateur;

    /**
     * @param string $titreQuestion
     * @param string $dateDebutPropostion
     * @param string $dateFinProposition
     * @param string $dateDebutVote
     * @param string $dateFinVote
     */
    public function __construct(string $titreQuestion, string $dateDebutPropostion, string $dateFinProposition, string $dateDebutVote, string $dateFinVote)
    {
        $this->titreQuestion = $titreQuestion;
        $this->dateDebutPropostion = $dateDebutPropostion;
        $this->dateFinProposition = $dateFinProposition;
        $this->dateDebutVote = $dateDebutVote;
        $this->dateFinVote = $dateFinVote;
    }

    public function tableFormat(): array
    {
        return [

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
    public function getDateDebutPropostion(): string
    {
        return $this->dateDebutPropostion;
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
    public function getMailOrganisateur(): string
    {
        return $this->mailOrganisateur;
    }
}
