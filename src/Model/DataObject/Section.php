<?php

namespace Themis\Model\DataObject;

class Section extends AbstractDataObject
{
    private ?int $idSection;
    private int $idQuestion;
    private ?string $titreSection;
    private ?string $descriptionSection;

    /**
     * @param int $idSection
     * @param int $idQuestion
     * @param string $titreSection
     * @param string $descriptionSection
     */
    public function __construct(?int $idSection, int $idQuestion, ?string $titreSection, ?string $descriptionSection)
    {
        $this->idSection = $idSection;
        $this->idQuestion = $idQuestion;
        $this->titreSection = $titreSection;
        $this->descriptionSection = $descriptionSection;
    }

    public function tableFormat(): array
    {

        if ($this->idSection == 0) {
            return [
                "idQuestion" => $this->idQuestion,
                "titreSection" => $this->titreSection,
                "descriptionSection" => $this->descriptionSection
            ];
        } else {
            return [
                "idSection" => $this->idSection,
                "idQuestion" => $this->idQuestion,
                "titreSection" => $this->titreSection,
                "descriptionSection" => $this->descriptionSection
            ];
        }
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

    public static function buildFromForm(array $formArray): AbstractDataObject
    {
        if (isset($formArray["idSection"])) {
            return new Section(
                $formArray["idSection"],
                $formArray["idQuestion"],
                $formArray["titreSection"],
                $formArray["descriptionSection"]);
        } else {
            return new Section(
                null,
                $formArray["idQuestion"],
                $formArray["titreSection"],
                $formArray["descriptionSection"]);
        }

    }
}