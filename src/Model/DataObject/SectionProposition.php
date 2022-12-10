<?php

namespace Themis\Model\DataObject;

class SectionProposition extends AbstractDataObject
{
    private int $idSectionProposition;
    private string $texteProposition;
    private int $idSection;
    private int $idProposition;

    /**
     * @param int $idSectionProposition
     * @param string $texteProposition
     * @param int $idSection
     * @param int $idProposition
     */
    public function __construct(int $idSectionProposition, string $texteProposition, int $idSection, int $idProposition)
    {
        $this->idSectionProposition = $idSectionProposition;
        $this->texteProposition = $texteProposition;
        $this->idSection = $idSection;
        $this->idProposition = $idProposition;
    }

    public function tableFormat(): array
    {
        if ($this->idSectionProposition == 0) {
            return [
                "texteProposition" => $this->texteProposition,
                "idSection" => $this->idSection,
                "idProposition" => $this->idProposition
            ];
        } else {
            return [
                "idSectionProposition" => $this->idSectionProposition,
                "texteProposition" => $this->texteProposition,
                "idSection" => $this->idSection,
                "idProposition" => $this->idProposition
            ];
        }
    }

    /**
     * @return int
     */
    public function getIdSectionProposition(): int
    {
        return $this->idSectionProposition;
    }

    /**
     * @return string
     */
    public function getTexteProposition(): string
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

    public static function buildFromForm(array $formArray): AbstractDataObject
    {
        return new SectionProposition(
            (int)null,
            $formArray['texteProposition'],
            $formArray['idSection'],
            $formArray['idProposition']
        );
    }
}
