<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\AbstractDataObject;
use Themis\Model\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository
{

    protected function getTableName(): string
    {
        return 'themis."Utilisateurs"';
    }

    protected function getPrimaryKey(): string
    {
        return "login";
    }

    protected function getOrderColumn(): string
    {
        return "login";
    }

    protected function getColumnNames(): array
    {
        return [
            "login",
            "nom",
            "prenom",
            "adresseMail",
            "dateNaissance",
            "mdp"
        ];
    }

    /**
     * @inheritDoc
     */
    public function build(array $objectArrayFormat): AbstractDataObject
    {
        return new Utilisateur($objectArrayFormat["login"],
            $objectArrayFormat["nom"],
            $objectArrayFormat["prenom"],
            $objectArrayFormat["adresseMail"],
            $objectArrayFormat["dateNaissance"],
            $objectArrayFormat["mdp"]
        );
    }
}