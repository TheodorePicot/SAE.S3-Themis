<?php

namespace Themis\Model\DataObject;

class Question extends AbstractDataObject
{
    private ?int $idQuestion;
    private string $titreQuestion;
    private string $descriptionQuestion;
    private string $dateDebutProposition;
    private string $dateFinProposition;
    private string $dateDebutVote;
    private string $dateFinVote;
    private string $loginOrganisateur;
    private string $systemeVote;

    /**
     * Permet de construire une Question à partir d'un idQuestion, d'un titreQuestion, d'une descriptionQuestion,
     * d'une dateDebutProposition, d'une dateFinProposition, d'une dateDebutVote et d'une dateFinVote
     *
     * @param int $idQuestion
     * @param string $titreQuestion
     * @param string $descriptionQuestion
     * @param string $dateDebutProposition
     * @param string $dateFinProposition
     * @param string $dateDebutVote
     * @param string $dateFinVote
     */
    public function __construct(?int    $idQuestion,
                                string $titreQuestion,
                                string $descriptionQuestion,
                                string $dateDebutProposition,
                                string $dateFinProposition,
                                string $dateDebutVote,
                                string $dateFinVote,
                                string $loginOrganisateur,
                                string $systemeVote)
    {
        $this->idQuestion = $idQuestion;
        $this->titreQuestion = $titreQuestion;
        $this->descriptionQuestion = $descriptionQuestion;
        $this->dateDebutProposition = $dateDebutProposition;
        $this->dateFinProposition = $dateFinProposition;
        $this->dateDebutVote = $dateDebutVote;
        $this->dateFinVote = $dateFinVote;
        $this->loginOrganisateur = $loginOrganisateur;
        $this->systemeVote = $systemeVote;
    }

    /**
     * Permet de retourner toutes les colonnes de la table Question
     *
     * @return array
     */
    public function tableFormat(): array
    {
        if ($this->idQuestion == 0) {
            return [
                "titreQuestion" => $this->titreQuestion,
                "descriptionQuestion" => $this->descriptionQuestion,
                "dateDebutProposition" => $this->dateDebutProposition,
                "dateFinProposition" => $this->dateFinProposition,
                "dateDebutVote" => $this->dateDebutVote,
                "dateFinVote" => $this->dateFinVote,
                "loginOrganisateur" => $this->loginOrganisateur,
                "systemeVote" => $this->systemeVote
            ];
        } else {
            return [
                "idQuestion" => $this->idQuestion,
                "titreQuestion" => $this->titreQuestion,
                "descriptionQuestion" => $this->descriptionQuestion,
                "dateDebutProposition" => $this->dateDebutProposition,
                "dateFinProposition" => $this->dateFinProposition,
                "dateDebutVote" => $this->dateDebutVote,
                "dateFinVote" => $this->dateFinVote,
                "loginOrganisateur" => $this->loginOrganisateur,
                "systemeVote" => $this->systemeVote
            ];
        }
    }

    /**
     * Permet de récupérer l'id d'une Question
     *
     * @return int
     */
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * Permet de récupérer le titre d'une Question
     *
     * @return string
     */
    public function getTitreQuestion(): string
    {
        return $this->titreQuestion;
    }

    /**
     * Permet de récupérer la DateDebutProposition d'une Question
     *
     * @return string
     */
    public function getDateDebutProposition(): string
    {
        return $this->dateDebutProposition;
    }

    /**
     * Permet de récupérer la DateFinProposition d'une Question
     *
     * @return string
     */
    public function getDateFinProposition(): string
    {
        return $this->dateFinProposition;
    }

    /**
     * Permet de récupérer la DateDebutVote d'une Question
     *
     * @return string
     */
    public function getDateDebutVote(): string
    {
        return $this->dateDebutVote;
    }

    /**
     * Permet de récupérer la DateFinVote d'une Question
     *
     * @return string
     */
    public function getDateFinVote(): string
    {
        return $this->dateFinVote;
    }

    /**
     * Permet de récupérer la Description d'une Question
     *
     * @return string
     */
    public function getDescriptionQuestion(): string
    {
        return $this->descriptionQuestion;
    }

    /**
     * Permet de récupérer le LoginOrganisateur d'une Question
     *
     * @return string
     */
    public function getLoginOrganisateur(): string
    {
        return $this->loginOrganisateur;
    }

    /**
     * Permet de récupérer la description d'une Question avec une taille de maximun 120
     *
     * @return string
     */
    public function getShortDescriptionQuestion(): string
    {
        $tmp = substr($this->descriptionQuestion, 0, 120);
        if (strlen($this->descriptionQuestion) > 120) $tmp .= "...";

        return $tmp;
    }

    /**
     * Permet de récupérer la SystemeVote d'une Question
     *
     * @return string
     */
    public function getSystemeVote(): string
    {
        return $this->systemeVote;
    }

    /**
     * Permet de construire une Question à partir d'une array
     *
     * @param array $formArray
     * @return Question
     */
    public static function buildFromForm(array $formArray): Question
    {
        if (isset($formArray["idQuestion"])) {
            return new Question(
                $formArray["idQuestion"],
                $formArray["titreQuestion"],
                $formArray["descriptionQuestion"],
                $formArray["dateDebutProposition"],
                $formArray["dateFinProposition"],
                $formArray["dateDebutVote"],
                $formArray["dateFinVote"],
                $formArray["loginOrganisateur"],
                $formArray["systemeVote"]);
        } else {
            return new Question(
                null,
                $formArray["titreQuestion"],
                $formArray["descriptionQuestion"],
                $formArray["dateDebutProposition"],
                $formArray["dateFinProposition"],
                $formArray["dateDebutVote"],
                $formArray["dateFinVote"],
                $formArray["loginOrganisateur"],
                $formArray["systemeVote"]);
        }

    }
}
