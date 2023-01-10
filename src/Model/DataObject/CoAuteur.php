<?php

namespace Themis\Model\DataObject;

class CoAuteur extends AbstractDataObject
{
    private int $idProposition;
    private string $login;

    /**
     * Permet de construire un CoAuteur avec un idProposition et un login
     *
     * @param int $idProposition
     * @param string $login
     */
    public function __construct(int $idProposition, string $login)
    {
        $this->idProposition = $idProposition;
        $this->login = $login;
    }

    /**
     * Permet de retourner toutes les colonnes de la table CoAuteur
     *
     * @return array
     */
    public function tableFormat(): array
    {
        return [
            "idProposition" => $this->idProposition,
            "login" => $this->login
        ];
    }

    /**
     * Permet de récupérer l'IdProposition d'un CoAuteur
     *
     * @return int
     */
    public function getIdProposition(): int
    {
        return $this->idProposition;
    }

    /**
     * Permet de récupérer le Login d'un CoAuteur
     *
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * Permet de construire un coAuteur à partir d'une array
     *
     * @param array $formArray
     * @return CoAuteur
     */
    public static function buildFromForm($formArray): CoAuteur
    {
        return new CoAuteur($formArray["idProposition"], $formArray["login"]);
    }
}