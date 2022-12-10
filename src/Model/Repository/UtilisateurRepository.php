<?php

namespace Themis\Model\Repository;

use Themis\Model\DataObject\Utilisateur;

class UtilisateurRepository extends AbstractRepository
{
    /**
     * @inheritDoc
     */
    public function build(array $objectArrayFormat): Utilisateur
    {
        if($objectArrayFormat["adresseMail"] == "") {
            return new Utilisateur($objectArrayFormat["login"],
                $objectArrayFormat["nom"],
                $objectArrayFormat["prenom"],
                "",
                $objectArrayFormat["dateNaissance"],
                $objectArrayFormat["mdp"],
                $objectArrayFormat["estAdmin"],
                $objectArrayFormat["estOrganisateur"],
                $objectArrayFormat["emailAValider"],
                $objectArrayFormat["nonce"]
            );
        } else {
            return new Utilisateur($objectArrayFormat["login"],
                $objectArrayFormat["nom"],
                $objectArrayFormat["prenom"],
                $objectArrayFormat["adresseMail"],
                $objectArrayFormat["dateNaissance"],
                $objectArrayFormat["mdp"],
                $objectArrayFormat["estAdmin"],
                $objectArrayFormat["estOrganisateur"],
                $objectArrayFormat["emailAValider"],
                $objectArrayFormat["nonce"]
            );
        }
    }

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
            "mdp",
            "estAdmin",
            "estOrganisateur",
            "emailAValider",
            "nonce"
        ];
    }

    public function updateInformation(array $newValues): void
    {
        var_dump($newValues);
        $sqlQuery = 'UPDATE ' . $this->getTableName() .  ' SET nom =:nom, prenom =:prenom, "adresseMail" =:adresseMail, "dateNaissance" =:dateNaissance, "estAdmin" =:estAdmin, "estOrganisateur" =:estOrganisateur WHERE login =:login';
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $pdoStatement->execute($newValues);
    }

    public function updatePassword(array $newValues): void
    {
        var_dump($newValues);
        $sqlQuery = 'UPDATE themis."Utilisateurs" SET mdp =:mdp WHERE login =:login';
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $pdoStatement->execute($newValues);
    }
}