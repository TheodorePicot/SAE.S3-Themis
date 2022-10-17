<?php

namespace Themis\Model;

class ModelQuestion
{

    private int $idQuestion;
    private string $titreQuestion;
    private string $dateDebutPropostion;
    private string $dateFinProposition;
    private string $dateDebutVote;
    private string $dateFinVote;
    private string $mailOrganisateur;

    /**
     * @param int $idQuestion
     * @param string $titre
     * @param string $dateDebutPropostion
     * @param string $dateFinProposition
     * @param string $dateDebutVote
     * @param string $dateFinVote
     */
    public function __construct(int $idQuestion, string $titre, string $dateDebutPropostion, string $dateFinProposition, string $dateDebutVote, string $dateFinVote, string $mailOrganisateur)
    {
        $this->idQuestion = $idQuestion;
        $this->titre = $titre;
        $this->dateDebutPropostion = $dateDebutPropostion;
        $this->dateFinProposition = $dateFinProposition;
        $this->dateDebutVote = $dateDebutVote;
        $this->dateFinVote = $dateFinVote;
        $this->mailOrganisateur = $mailOrganisateur;
    }

    public function saveIntoDatabase() : bool
    {
        $query = "INSERT INTO 
                  Questions (titreQuestion, dateDebutPropostion, dateFinProposition,dateDebutVote, dateFinVote, mailOrganisateur) 
                  VALUES (:titreQuestion,  :dateDebutPropostion, :dateFinProposition,:dateDebutVote, :dateFinVote, :mailOrganisateur)";
        $pdoStatement = Model::getPdo()->prepare($query);

        $values = [
            "titreQuestion" => $this->titreQuestion,
            "dateDebutProposition" => $this->dateDebutPropostion,
            "dateFinProposistion" => $this->dateFinProposition,
            "dateDebutVote" => $this->dateDebutVote,
            "dateFinVote" => $this->dateFinVote,
            "mailOrganisateur" => $this->mailOrganisateur
        ];

        $pdoStatement->execute($values);

        return true; //TODO Try catch PDO exception with SQL errors
    }

}