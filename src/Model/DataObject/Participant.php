<?php

namespace Themis\Model\DataObject;

class Participant extends AbstractDataObject
{
    private string $login;
    private int $idQuestion;

    /**
     * permet de construire un Partcipant à partir d'un login et d'un idQuestion
     *
     * @param string $login
     * @param int $idQuestion
     */
    public function __construct(string $login, int $idQuestion)
    {
        $this->login = $login;
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
            "login" => $this->login,
            "idQuestion" => $this->idQuestion
        ];
    }

    /**
     * permet de récupérer le login d'un participant
     *
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
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
        return new Participant($formArray['login'], $formArray['idQuestion']);
    }
}