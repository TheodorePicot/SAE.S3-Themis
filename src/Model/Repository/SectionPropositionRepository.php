<?php


namespace Themis\Model\Repository;

use Themis\Model\DataObject\SectionProposition;
use Themis\Model\Repository\AbstractRepository;

class SectionPropositionRepository extends AbstractRepository {


    protected function getTableName(): string
    {
        // TODO: Implement getTableName() method.
        return 'themis."SectionProposition"';

    }

    protected function getPrimaryKey(): string
    {
        // TODO: Implement getPrimaryKey() method.
        return "idSectionProposition";

    }

    protected function getColumnNames(): array
    {
        // TODO: Implement getColumnNames() method.
        return [
            'texteProposition',
            'idSection',
            'idProposition'
        ];
    }

    protected function getOrderColumn(): string
    {
        return "";
    }

    public function build(array $objectArrayFormat): SectionProposition
    {
        // TODO: Implement build() method.
        if (isset($objectArrayFormat['idSectionProposition'])) { //la sectionProposition existe déjà
            return new SectionProposition($objectArrayFormat['idSectionProposition'], $objectArrayFormat['texteProposition'], $objectArrayFormat['idSection'], $objectArrayFormat['idProposition']);
        } else {
            return new SectionProposition((int)null, $objectArrayFormat['texteProposition'], $objectArrayFormat['idSection'], $objectArrayFormat['idProposition']);
        }
    }

    public function selectAllByProposition($idProposition): array
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "SELECT * FROM $databaseTable WHERE " . '"idProposition"=:idProposition';
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

    public function selectByPropositionAndSection(int $idProposition, int $idSection): ?SectionProposition
    {
        $databaseTable = $this->getTableName();
        $sqlQuery = "SELECT * FROM $databaseTable WHERE " . '"idProposition"=:idProposition AND "idSection" =:idSection';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $values = [
            "idProposition" => $idProposition,
            "idSection" => $idSection
        ];

        $pdoStatement->execute($values);
        if ($objetTableFormat = $pdoStatement->fetch()) return $this->build($objetTableFormat);
        else return null;
    }

}

