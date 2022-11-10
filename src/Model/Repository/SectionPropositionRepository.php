<?php


namespace Themis\Model\Repository;

use Themis\Model\DataObject\SectionProposition;
use Themis\Model\Repository\AbstractRepository;

class SectionPropositionRepository extends AbstractRepository {


    protected function getTableName(): string
    {
        // TODO: Implement getTableName() method.
        return 'themis."SectionPropositionRepository"';

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
            'textProposition',
            'idSection',
            'idProposition'
        ];
    }

    public function build(array $objectArrayFormat): \Themis\Model\DataObject\SectionProposition
    {
        // TODO: Implement build() method.
        if (isset($objectArrayFormat['idSectionProposition'])) { //la sectionProposition existe déjà
            return new SectionProposition($objectArrayFormat['idSectionProposition'], $objectArrayFormat['textProposition'], $objectArrayFormat['idSection'], $objectArrayFormat['odProposition']);
        } else {  //la proposition n'existe pas (ex : formulaire)
            return new SectionProposition((int)null, $objectArrayFormat['textProposition'], $objectArrayFormat['idSection'], $objectArrayFormat['odProposition']);
        }
    }
}

