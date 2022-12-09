<?php

namespace Themis\Model\DataObject;

class CoAuteur extends AbstractDataObject
{
    private int $idProposition;
    private string $login;

    /**
     * @param int $idProposition
     * @param string $login
     */
    public function __construct(int $idProposition, string $login)
    {
        $this->idProposition = $idProposition;
        $this->login = $login;
    }

    public function tableFormat(): array
    {
        return [
            "idProposition" => $this->idProposition,
            "login" => $this->login
        ];
    }

    /**
     * @return int
     */
    public function getIdProposition(): int
    {
        return $this->idProposition;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    public static function buildFromForm($formArray): CoAuteur
    {
        return new CoAuteur($formArray["idProposition"], $formArray["login"]);
    }
}