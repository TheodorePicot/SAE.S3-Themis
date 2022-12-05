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
        $sqlQuery = "SELECT isAuteurInQuestion(:login, :idProposition)";

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = array(
            'login' => $login,
            'idProposition' => $idProposition
        );

        $pdoStatement->execute($values);

        $dataObject = $pdoStatement->fetch();

        return $dataObject['isauteurinquestion'] == "true";
    }
}