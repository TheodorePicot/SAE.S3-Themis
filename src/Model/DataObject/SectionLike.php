<?php

namespace Themis\Model\DataObject;

class SectionLike extends AbstractDataObject
{

    private string $login;
    private int $idSectionProposition;

    /**
     * @param string $login
     * @param int $idSectionProposition
     */
    public function __construct(string $login, int $idSectionProposition)
    {
        $this->login = $login;
        $this->idSectionProposition = $idSectionProposition;
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
    public function getIdSectionProposition(): int
    {
        return $this->idSectionProposition;
    }


    public function tableFormat(): array
    {
            return [
                "login" => $this->login,
                "idSectionProposition" => $this->idSectionProposition
            ];
    }

    public static function buildFromForm(array $formArray): AbstractDataObject
    {
        return new SectionLike(
            $formArray["login"],
            $formArray["idSectionProposition"]
        );
    }
}
