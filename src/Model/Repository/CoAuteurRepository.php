<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\CoAuteur;

class CoAuteurRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'themis."estCoAuteur"';
    }

    protected function getColumnNames(): array
    {
        return [
            "idProposition",
            "login"
        ];
    }

    /**
     * @inheritDoc
     */
    public function build(array $objectArrayFormat): AbstractDataObject
    {
        return new CoAuteur($objectArrayFormat["idProposition"], $objectArrayFormat["login"]);
    }

    protected function getOrderColumn(): string
    {
        return "login";
    }

    protected function getPrimaryKey(): string
    {
        return "idProposition";
    }

    public function isCoAuteurInProposition(string $login, int $idProposition): bool
    {
        $sqlQuery = "SELECT isCoAuteurInProposition(:login, :idProposition)";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'login' => $login,
            'idProposition' => $idProposition
        );

        $pdoStatement->execute($values);

        $dataObject = $pdoStatement->fetch();

        return $dataObject['iscoauteurinproposition'] == "true";
    }

    public function coAuteurIsInQuestion(string $login, int $idQuestion): bool
    {
        $sqlQuery = "SELECT login FROM {$this->getTableName()} co
                     JOIN " . '"Propositions"' . ' p ON co."idProposition" = p."idProposition" ' .
                    'JOIN "Questions" q ON p."idQuestion" = q."idQuestion" 
                    WHERE q."idQuestion" = :idQuestion';
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'idQuestion' => $idQuestion
        );

        $pdoStatement->execute($values);

        $dataObject = $pdoStatement->fetch();
        if ($dataObject != false) {
            return $dataObject == $login;
        }
        return false;
    }

    public function selectAllByProposition($idProposition): array
    {
        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"idProposition"=:idProposition ORDER BY ' . $this->getOrderColumn();
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idProposition" => $idProposition
        ];

        $pdoStatement->execute($values);

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }
}