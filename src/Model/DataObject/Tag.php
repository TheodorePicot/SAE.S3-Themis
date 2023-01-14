<?php

namespace Themis\Model\DataObject;

class Tag extends AbstractDataObject
{
    private string $nom;
    private int $idQuestion;

    /**
     * permet de construire un Partcipant à partir d'un login et d'un idQuestion
     *
     * @param string $nom
     * @param int $idQuestion
     */
    public function __construct(string $nom, int $idQuestion)
    {
        $this->nom = $nom;
        $this->idQuestion = $idQuestion;
    }

    /**
     * permet de retourner toutes les colonnes de la table Participant
     *
     * @return array
     */
    public function tableFormat(): array
    {
        return [
            "login" => $this->nom,
            "idQuestion" => $this->idQuestion
        ];
    }

    /**
     * permet de récupérer le login d'un participant
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * permet de récupérer l'idQuestion d'un participant
     *
     * @return int
     */
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * permet de construire un Participant à partir d'une array
     *
     * @param array $formArray
     * @return AbstractDataObject
     */
    public static function buildFromForm(array $formArray): AbstractDataObject
    {
        return new Tag($formArray['nom'], $formArray['idQuestion']);
    }
}
