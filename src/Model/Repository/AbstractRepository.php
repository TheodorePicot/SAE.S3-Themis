<?php

namespace Themis\Model\Repository;

use PDOException;
use Themis\Model\DataObject\AbstractDataObject;

abstract class AbstractRepository
{
    /**
     * Le AbstractDataObject $dataObject est un objet qui vient d'etre créer par la méthode {@link build()}
     * Cette méthode prend donc un objet PHP et insère les données de cet objet dans notre base de données et la table correspondante.
     * @param AbstractDataObject $dataObject
     * @return bool
     */
    public function create(AbstractDataObject $dataObject): string // TODO Refactor this
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "INSERT INTO $databaseTable (";
        $columnValues = "VALUES (";
        $count = 0;
        foreach ($this->getColumnNames() as $columnName) {
            if ($count != 0) {
                $sqlQuery .= ",";
                $columnValues .= ",";
            }
            $sqlQuery .= '"' . $columnName . '"';
            $columnValues .= ":$columnName";
            $count++;
        }
        $sqlQuery .= ") " . $columnValues . ")";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = $dataObject->tableFormat();
        echo $sqlQuery;
        var_dump($values);
        try {
            $pdoStatement->execute($values);
        } catch (PDOException $exception) {
            echo $exception->getCode();
            return $exception->getCode();
        }
        return "";
    }

    protected abstract function getTableName(): string;

    protected abstract function getColumnNames(): array;

    public function selectAll(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()}");

        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    /**
     * Cette fonction nous permet de prendre les attributs bruts, dans une liste, donnés par un utilisateur.
     * Nous transformons cette liste possédant les attributs en DataObject.
     * Cela nous permet de manipuler les données.
     * @param array $objectArrayFormat
     * @return AbstractDataObject
     */
    abstract public function build(array $objectArrayFormat): AbstractDataObject;

    public function selectAllOrdered(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} ORDER BY {$this->getOrderColumn()}");
        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

    protected abstract function getOrderColumn(): string;

    public function select(string $primaryKeyValue): ?AbstractDataObject
    {
        $databaseTable = $this->getTableName();
        $primaryKey = $this->getPrimaryKey();
        $sqlQuery = "SELECT * from $databaseTable WHERE" . '"' . $primaryKey . '"' . "=:primaryKey";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $values = array(
            'primaryKey' => $primaryKeyValue
        );
        $pdoStatement->execute($values);
        $dataObject = $pdoStatement->fetch();

        if (!$dataObject) return null;

        return $this->build($dataObject);
    }

    protected abstract function getPrimaryKey(): string;

    public function update(AbstractDataObject $dataObject): void
    {
        $databaseTable = $this->getTableName();
        $primaryKey = $this->getPrimaryKey();
        $sqlQuery = "UPDATE $databaseTable SET ";
        $count = 0;
        foreach ($this->getColumnNames() as $columnName) {
            if ($count != 0) {
                $sqlQuery .= ",";
            }
            $sqlQuery .= '"' . $columnName . '"' . "=:$columnName";
            $count++;
        }
        $sqlQuery .= " WHERE " . '"' . $primaryKey . '"' . "=:$primaryKey";
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = $dataObject->tableFormat();
        $pdoStatement->execute($values);
    }

    public function delete(string $primaryKeyValue): bool
    {
        $databaseTable = $this->getTableName();
        $primaryKey = $this->getPrimaryKey();
        $sqlQuery = "DELETE FROM $databaseTable WHERE" . '"' . $primaryKey . '"' . "=:primaryKey";
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "primaryKey" => $primaryKeyValue
        ];

        return $pdoStatement->execute($values);
    }
}