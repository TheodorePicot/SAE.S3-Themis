<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Participant;

abstract class AbstractParticipantRepository extends AbstractRepository
{
    abstract public function isParticpantInQuestion(string $login, int $idQuestion): bool;

    protected function getPrimaryKey(): string
    {
        return "idQuestion";
    }

    protected function getOrderColumn(): string
    {
        return "login";
    }

    protected function getColumnNames(): array
    {
        return [
            "login",
            "idQuestion"
        ];
    }

    public function build(array $objectArrayFormat): AbstractDataObject
    {
        return new Participant($objectArrayFormat['login'], $objectArrayFormat['idQuestion']);
    }

    public function selectAllByQuestion($idQuestion): array
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "SELECT * FROM $databaseTable WHERE " . '"idQuestion"=:idQuestion' . " ORDER BY " . $this->getOrderColumn();
//        echo $sqlQuery;
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

//    public function selectAllOrderedByNameByQuestion($idQuestion): array
//    {
//        $databaseTable = $this->getTableName();
//        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM $databaseTable WHERE " . '"idQuestion"=:idQuestion ' . "ORDER BY " . $this->getOrderColumn());
//        echo "SELECT * FROM $databaseTable ORDER BY " . $this->getOrderColumn();
//        $dataObjects = array();
//        foreach ($pdoStatement as $dataObject) {
//            $dataObjects[] = $this->build($dataObject);
//        }
//
//        return $dataObjects;
//    }
}