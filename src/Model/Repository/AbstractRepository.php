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


        try {
            $pdoStatement->execute($values);
        } catch (PDOException $exception) {
            echo $exception->getCode();
            return $exception->getCode();
        }
        return "";
    }

    /**
     * Permet d'obtenir le nom de la table du DataObject manipulé
     *
     * @return string
     */
    protected abstract function getTableName(): string;

    /**
     * Permet d'obtenir un tableau avec tout les noms de colonne du DataObject manipulé
     *
     * @return array
     */
    protected abstract function getColumnNames(): array;

    /**
     * Permet d'obtenir un tableau avec toute les données dans la BD de la table du DataObject manipulé
     *
     * @return array
     */
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
     * Cette fonction permet de prendre les attributs bruts, dans une liste, donnés par un utilisateur.
     *
     * Nous transformons cette liste possédant les attributs en DataObject.
     * Cela permet de manipuler les données.
     *
     * @param array $objectArrayFormat
     * @return AbstractDataObject
     */
    abstract protected function build(array $objectArrayFormat): AbstractDataObject;

    /**
     * Permet d'obtenir un tableau avec toute les données dans la BD de la table du DataObject manipulé en fonction de
     * {@link AbstractRepository::getOrderColumn()}
     *
     * @return array
     */
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

    /**
     * Permet d'obtenir les données de la BD ayant comme clé primaire le string placé en paramètre si elles existent sinon
     * return null
     *
     * @param string $primaryKeyValue
     * @return AbstractDataObject|null
     */
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

    /**
     * Permet d'obtenir la clé primaire de la table du DataObject manipulé
     *
     * @return string
     */
    protected abstract function getPrimaryKey(): string;

    /**
     * Permet de mettre à jour le DataObject placé en paramètre
     *
     * @param AbstractDataObject $dataObject
     * @return void
     */
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

        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = $dataObject->tableFormat();

        $pdoStatement->execute($values);
    }

    /**
     * Permet de supprimer les données de la BD ayant comme clé primaire le string placé en paramètre si elles existent
     * return true sinon return false
     *
     * @param string $primaryKeyValue
     * @return bool
     */
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

    /**
     * Permet d'obtenir un tableau avec toute les données dans la BD de la table du DataObject manipulé en fonction de
     * {@link AbstractRepository::getOrderColumn()}
     * Ce tableau est limité à 10 DataObject
     *
     * @return array
     */
    public function selectAllOrderedWithLimit(): array
    {

        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} ORDER BY {$this->getOrderColumn()} LIMIT 10");

        $dataObjects = array(); 
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }

        return $dataObjects;
    }

}