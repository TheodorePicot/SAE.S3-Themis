<?php

namespace Themis\Model\DataObject;

class SectionLike extends AbstractDataObject
{

    private string $login;
    private int $idSection;

    /**
     * @param string $login
     * @param int $idSection
     */
    public function __construct(string $login, int $idSection)
    {
        $this->login = $login;
        $this->idSection = $idSection;
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
    public function getIdSection(): int
    {
        return $this->idSection;
    }


    public function tableFormat(): array
    {
            return [
                "login" => $this->login,
                "idSection" => $this->idSection
            ];
    }

    public static function buildFromForm(array $formArray): AbstractDataObject
    {
        return new SectionLike(
            $formArray["login"],
            $formArray["idSection"]
        );
    }
}
