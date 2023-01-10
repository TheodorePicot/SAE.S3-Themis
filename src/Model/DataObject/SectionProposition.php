<?php

namespace Themis\Model\DataObject;

class SectionProposition extends AbstractDataObject
{
    private ?int $idSectionProposition;
    private string $texteProposition;
    private int $idSection;
    private int $idProposition;

    /**
     * permet de construire une SectionProposition à partir d'un idSectionProposition, d'un texteProposition, d'un idSection et d'un idProposition
     *
     * @param int|null $idSectionProposition
     * @param string $texteProposition
     * @param int $idSection
     * @param int $idProposition
     */
    public function __construct(?int $idSectionProposition, string $texteProposition, int $idSection, int $idProposition)
    {
        $this->idSectionProposition = $idSectionProposition;
        $this->texteProposition = $texteProposition;
        $this->idSection = $idSection;
        $this->idProposition = $idProposition;
    }

    /**
     * permet de retourner toutes les colonnes de la table SectionProposition
     *
     * @return array
     */
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
     * permet de récupérer l'Id d'une SectionProposition
     *
     * @return int
     */
    public function getIdSectionProposition(): int
    {
        return $this->idSectionProposition;
    }

    /**
     * permet de récupérer le TexteProposition d'une SectionProposition
     *
     * @return string
     */
    public function getTexteProposition(): string
    {
        return $this->texteProposition;
    }

    /**
     * permet de récupérer l'IdSection d'une SectionProposition
     *
     * @return int
     */
    public function getIdSection(): int
    {
        return $this->idSection;
    }

    /**
     * permet de récupérer l'IdProposition d'une SectionProposition
     *
     * @return int
     */
    public function getIdProposition(): int
    {
        return $this->idProposition;
    }

    /**
     * permet de construire une SectionProposition à partir d'une array
     *
     * @param array $formArray
     * @return AbstractDataObject
     */
    public static function buildFromForm(array $formArray): AbstractDataObject
    {
        if ($formArray['idSectionProposition']) {
            return new SectionProposition(
                $formArray['idSectionProposition'],
                $formArray['texteProposition'],
                $formArray['idSection'],
                $formArray['idProposition']
            );
        } else {
            return new SectionProposition(
                null,
                $formArray['texteProposition'],
                $formArray['idSection'],
                $formArray['idProposition']
            );
        }

    }
}
