<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Proposition;

class PropositionRepository extends AbstractRepository {


    protected function getTableName(): string
    {
        // TODO: Implement getTableName() method.
        return 'themis."Proposition"';
    }

    protected function getPrimaryKey(): string
    {
        // TODO: Implement getPrimaryKey() method.
        return "idProposition";
    }

    protected function getColumnNames(): array
    {
        // TODO: Implement getColumnNames() method.
        return [
            "idQuestion",
            "titreProposition"
        ];
    }

    public function build(array $objectArrayFormat): Proposition
    {
        // TODO: Implement build() method.
        if (isset($objectArrayFormat['idProposition'])) { //la proposition existe déjà
            return new Proposition($objectArrayFormat['idProposition'], $objectArrayFormat['idQuestion'], $objectArrayFormat['titreProposition']);
        } else {  //la proposition n'existe pas (ex : formulaire)
            return new Proposition((int)null,$objectArrayFormat['idQuestion'], $objectArrayFormat['titreProposition']);
        }
    }
}