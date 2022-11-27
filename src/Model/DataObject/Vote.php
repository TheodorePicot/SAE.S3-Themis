<?php

namespace Themis\Model\DataObject;

class Vote extends AbstractDataObject
{

    private string $login;
    private int $idProposition;

    /**
     * @param string $login
     * @param int $idProposition
     */
    public function __construct(string $login, int $idProposition)
    {
        $this->login = $login;
        $this->idProposition = $idProposition;
    }

    public function tableFormat(): array
    {
        return [
            "login" => $this->login,
            "idPropositio" => $this->idProposition
        ];
    }
}