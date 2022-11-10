<?php

namespace Themis\Model\DataObject;

class SectionProposition extends AbstractDataObject {

    private int $idSectionProposition;
    private text $texteProposition;
    private int $idSection;
    private int $idProposition;

    /**
     * @param int $idSectionProposition
     * @param text $texteProposition
     * @param int $idSection
     * @param int $idProposition
     */
    public function __construct(int $idSectionProposition, text $texteProposition, int $idSection, int $idProposition)
    {
        $this->idSectionProposition = $idSectionProposition;
        $this->texteProposition = $texteProposition;
        $this->idSection = $idSection;
        $this->idProposition = $idProposition;
    }

    /**
     * @return int
     */
    public function getIdSectionProposition(): int
    {
        return $this->idSectionProposition;
    }

    /**
     * @return text
     */
    public function getTexteProposition(): text
    {
        return $this->texteProposition;
    }

    /**
     * @return int
     */
    public function getIdSection(): int
    {
        return $this->idSection;
    }

    /**
     * @return int
     */
    public function getIdProposition(): int
    {
        return $this->idProposition;
    }


    public function tableFormatWithoutPrimaryKey(): array
    {
        // TODO: Implement tableFormatWithoutPrimaryKey() method.
        return [
            "idSectionProposition" => $this->idSectionProposition
        ];
    }

    public function tableFormatWithPrimaryKey(): array
    {
        // TODO: Implement tableFormatWithPrimaryKey() method.
        return [
            "texteProposition" => $this->texteProposition,
            "idSection" => $this->idSection,
            "idProposition" => $this->idProposition
        ];
    }
}
