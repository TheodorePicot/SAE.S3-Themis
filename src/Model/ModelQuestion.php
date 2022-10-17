<?php


namespace Themis\Model;

class ModelQuestion
{

    private int $idQuestion;
    private string $titre;
    private string $dateDebutPropostion;
    private string $dateFinProposition;
    private string $dateDebutVote;
    private string $dateFinVote;

    /**
     * @param int $idQuestion
     * @param string $titre
     * @param string $dateDebutPropostion
     * @param string $dateFinProposition
     * @param string $dateDebutVote
     * @param string $dateFinVote
     */
    public function __construct(int $idQuestion, string $titre, string $dateDebutPropostion, string $dateFinProposition, string $dateDebutVote, string $dateFinVote)
    {
        $this->idQuestion = $idQuestion;
        $this->titre = $titre;
        $this->dateDebutPropostion = $dateDebutPropostion;
        $this->dateFinProposition = $dateFinProposition;
        $this->dateDebutVote = $dateDebutVote;
        $this->dateFinVote = $dateFinVote;
    }

}