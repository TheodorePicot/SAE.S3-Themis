<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Section;

class SectionRepository extends AbstractRepository
{
    protected function getTableName(): string
    {
        return 'themis."Sections"';
    }

    protected function getPrimaryKey(): string
    {
        return "idSection";
    }

    protected function getColumnNames(): array
    {
        return [
            "idQuestion",
            "titreSection",
            "descriptionSection"
        ];
    }

    public function selectAllByQuestion($idQuestion): array
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "SELECT * FROM $databaseTable WHERE " . '"idQuestion"=:idQuestion';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idQuestion" => $idQuestion
        ];

        $pdoStatement->execute($values);

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    protected function build(array $sectionArrayFormat): AbstractDataObject
    {
        if ($sectionArrayFormat["titreSection"] == "" || $sectionArrayFormat["descriptionSection"] == "") {
            return new Section($sectionArrayFormat["idSection"],
                $sectionArrayFormat["idQuestion"],
                "",
                "");
        }

        if (isset($sectionArrayFormat["idSection"])) {
            return new Section($sectionArrayFormat["idSection"],
                $sectionArrayFormat["idQuestion"],
                $sectionArrayFormat["titreSection"],
                $sectionArrayFormat["descriptionSection"]);
        } else {
            return new Section((int)null,
                $sectionArrayFormat["idQuestion"],
                $sectionArrayFormat["titreSection"],
                $sectionArrayFormat["descriptionSection"]);
        }
    }

}