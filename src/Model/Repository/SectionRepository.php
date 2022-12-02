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

    protected function getOrderColumn(): string
    {
        return "idSection";
    }


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

    public function build(array $objectArrayFormat): AbstractDataObject
    {
        if ($objectArrayFormat["titreSection"] == "" || $objectArrayFormat["descriptionSection"] == "") {
            return new Section($objectArrayFormat["idSection"],
                $objectArrayFormat["idQuestion"],
                "",
                "");
        }

        if (isset($objectArrayFormat["idSection"])) {
            return new Section($objectArrayFormat["idSection"],
                $objectArrayFormat["idQuestion"],
                $objectArrayFormat["titreSection"],
                $objectArrayFormat["descriptionSection"]);
        } else {
            return new Section((int)null,
                $objectArrayFormat["idQuestion"],
                $objectArrayFormat["titreSection"],
                $objectArrayFormat["descriptionSection"]);
        }
    }

}