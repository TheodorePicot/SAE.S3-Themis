<?php

namespace Themis\Model\DataObject;

class Section extends AbstractDataObject
{
    private ?int $idSection;
    private int $idQuestion;
    private ?string $titreSection;
    private ?string $descriptionSection;

    /**
     * permet de construire une Section à partir d'un idSection, d'un idQuestion, d'un titreSection et d'une descriptionSection
     *
     * @param int|null $idSection
     * @param int $idQuestion
     * @param string|null $titreSection
     * @param string|null $descriptionSection
     */
    public function __construct(?int $idSection, int $idQuestion, ?string $titreSection, ?string $descriptionSection)
    {
        $this->idSection = $idSection;
        $this->idQuestion = $idQuestion;
        $this->titreSection = $titreSection;
        $this->descriptionSection = $descriptionSection;
    }

    /**
     * permet de retourner toutes les colonnes de la table Section
     *
     * @return array
     */
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
     * permet de récupérer l'IdSection d'une Section
     *
     * @return int
     */
    public function getIdSection(): int
    {
        return $this->idSection;
    }

    /**
     * permet de récupérer l'IdQuestion d'une Section
     *
     * @return int
     */
    public function getIdQuestion(): int
    {
        return $this->idQuestion;
    }

    /**
     * permet de récupérer le Titre d'une Section
     *
     * @return string
     */
    public function getTitreSection(): string
    {
        return $this->titreSection;
    }

    /**
     * permet de récupérer la Description d'une Section
     *
     * @return string
     */
    public function getDescriptionSection(): string
    {
        return $this->descriptionSection;
    }

    /**
     * permet de construire une Section à partir d'une array
     *
     * @param array $formArray
     * @return AbstractDataObject
     */
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