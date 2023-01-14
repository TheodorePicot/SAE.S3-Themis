<?php


namespace Themis\Model\Repository;

use Themis\Model\DataObject\SectionProposition;

class SectionPropositionRepository extends AbstractRepository
{


    public function selectAllByProposition($idProposition): array // TODO Faire trigger pour ajouter une section proposition quand ajoute section dans question
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



    protected function getTableName(): string
    {
        return 'themis."SectionProposition"';
    }

    public function build(array $objectArrayFormat): SectionProposition
    {
        return new SectionProposition(
            $objectArrayFormat['idSectionProposition'],
            $objectArrayFormat['texteProposition'],
            $objectArrayFormat['idSection'],
            $objectArrayFormat['idProposition']
        );
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

    protected function getPrimaryKey(): string
    {
        return "idSectionProposition";

    }

    protected function getColumnNames(): array
    {
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

}

