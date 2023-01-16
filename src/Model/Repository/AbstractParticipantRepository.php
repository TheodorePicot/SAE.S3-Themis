<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Participant;

abstract class AbstractParticipantRepository extends AbstractRepository
{
    abstract public function isParticpantInQuestion(string $login, int $idQuestion): bool;

    public function selectAllByQuestion($idQuestion): array
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "SELECT * FROM $databaseTable WHERE " . '"idQuestion"=:idQuestion ORDER BY ' . $this->getOrderColumn();
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

    protected function getOrderColumn(): string
    {
        return "login";
    }

    public function build(array $objectArrayFormat): Participant
    {
        return new Participant($objectArrayFormat['login'], $objectArrayFormat['idQuestion']);
    }

    protected function getPrimaryKey(): string
    {
        return "idQuestion";
    }

    protected function getColumnNames(): array
    {
        return [
            "login",
            "idQuestion"
        ];
    }


    public function selectAllOrderedByQuestionWithLimit($idQuestion): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE \"idQuestion\"=:idQuestion ORDER BY {$this->getOrderColumn()} LIMIT 10";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'idQuestion' => $idQuestion,
        );
        $pdoStatement->execute($values);
        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }
        return $dataObjects;
    }

    public function selectAllParticipantsBySearchValue(string $element, int $idQuestion) : array
    {

        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"idQuestion"=?' . ' AND LOWER("login") LIKE ? ';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array($idQuestion, "%" . strtolower($element) . "%"));

        $users = array();
        foreach ($pdoStatement as $user) {
            $users[] = $this->build($user);
        }
        return $users;
    }

}