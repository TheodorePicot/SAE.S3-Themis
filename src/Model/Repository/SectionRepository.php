<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Section;

class SectionRepository extends AbstractRepository
{
    public function selectAllByQuestion($idQuestion): array
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "SELECT * FROM $databaseTable WHERE " . '"idQuestion"=:idQuestion ORDER BY "idSection" ';
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

    protected function getTableName(): string
    {
        return 'themis."Sections"';
    }

    public function build(array $objectArrayFormat): Section
    {
        if ($objectArrayFormat["titreSection"] == "" || $objectArrayFormat["descriptionSection"] == "") {
            return new Section($objectArrayFormat["idSection"],
                $objectArrayFormat["idQuestion"],
                "",
                "");
        } else {
            return new Section($objectArrayFormat["idSection"],
                $objectArrayFormat["idQuestion"],
                $objectArrayFormat["titreSection"],
                $objectArrayFormat["descriptionSection"]);
        }
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

    protected function getOrderColumn(): string
    {
        return "idSection";
    }
}