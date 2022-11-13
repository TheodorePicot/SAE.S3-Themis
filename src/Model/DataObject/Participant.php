<?php

namespace Themis\Model\DataObject;

class Participant extends AbstractDataObject
{
    private string $login;
    private int $idQuestion;

    /**
     * @param string $login
     * @param int $idQuestion
     */
    public function __construct(string $login, int $idQuestion)
    {
        $this->login = $login;
        $this->idQuestion = $idQuestion;
    }

    public function tableFormat(): array
    {
        return [
            "login" => $this->login,
            "idQuestion" => $this->idQuestion
        ];
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return int
     */
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }
}