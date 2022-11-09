<?php

namespace Themis\Model\DataObject;

class Section extends AbstractDataObject
{
    private int $idSection;
    private int $idQuestion;
    private string $titreSection;
    private string $descriptionSection;

    /**
     * @param int $idSection
     * @param int $idQuestion
     * @param string $titreSection
     * @param string $descriptionSection
     */
    public function __construct(int $idSection, int $idQuestion, string $titreSection, string $descriptionSection)
    {
        $this->idSection = $idSection;
        $this->idQuestion = $idQuestion;
        $this->titreSection = $titreSection;
        $this->descriptionSection = $descriptionSection;
    }

    public function tableFormatWithoutPrimaryKey(): array
    {
        return [
            "idQuestion" => $this->idQuestion,
            "titreSection" => $this->titreSection,
            "descriptionSection" => $this->descriptionSection
        ];
    }

    public function tableFormatWithPrimaryKey(): array
    {
        return [
            "idSection" => $this->idSection,
            "idQuestion" => $this->idQuestion,
            "titreSection" => $this->titreSection,
            "descriptionSection" => $this->descriptionSection
        ];
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
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * @return string
     */
    public function getTitreSection(): string
    {
        return $this->titreSection;
    }

    /**
     * @return string
     */
    public function getDescriptionSection(): string
    {
        return $this->descriptionSection;
    }
}