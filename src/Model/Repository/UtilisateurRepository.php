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
        if ($objectArrayFormat["adresseMail"] == "") {
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
        $sqlQuery = 'UPDATE ' . $this->getTableName() . ' SET nom =:nom, prenom =:prenom, "adresseMail" =:adresseMail, "dateNaissance" =:dateNaissance, "estAdmin" =:estAdmin, "estOrganisateur" =:estOrganisateur WHERE login =:login';
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $pdoStatement->execute($newValues);
    }

    public function updatePassword(array $newValues): void
    {
        var_dump($newValues);
        $sqlQuery = "UPDATE {$this->getTableName()} SET mdp =:mdp WHERE login =:login";
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $pdoStatement->execute($newValues);
    }


    public function selectAllBySearchValue(string $element): array
    {

        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . 'LOWER("login") LIKE ? ';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array("%" . strtolower($element) . "%"));

        $users = array();
        foreach ($pdoStatement as $user) {
            $users[] = $this->build($user);
        }
        return $users;
    }

    public function selectAllAdminBySearchValue(string $element): array
    {

        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"estAdmin" is TRUE ' . ' AND LOWER("login") LIKE ? ';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array("%" . strtolower($element) . "%"));

        $users = array();
        foreach ($pdoStatement as $user) {
            $users[] = $this->build($user);
        }
        return $users;
    }

    public function selectAllOrganisateurBySearchValue(string $element): array
    {

        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"estOrganisateur" is TRUE AND "estAdmin" is NOT TRUE' . ' AND LOWER("login") LIKE ? ';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array("%" . strtolower($element) . "%"));

        $users = array();
        foreach ($pdoStatement as $user) {
            $users[] = $this->build($user);
        }
        return $users;
    }

    public function selectAllUtilisateurBySearchValue(string $element): array
    {

        $sqlQuery = "SELECT * FROM {$this->getTableName()} WHERE " . '"estAdmin" is NOT TRUE AND "estOrganisateur" IS NOT TRUE' . ' AND LOWER("login") LIKE ? ';
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);

        $pdoStatement->execute(array("%" . strtolower($element) . "%"));

        $users = array();
        foreach ($pdoStatement as $user) {
            $users[] = $this->build($user);
        }
        return $users;
    }


    public function selectAllOrderedAdminWithLimit(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} WHERE" . '"estAdmin" is TRUE ORDER BY ' . "{$this->getOrderColumn()} LIMIT 10");
        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }
        return $dataObjects;
    }

    public function selectAllOrderedOrganisateurWithLimit(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()}  WHERE" . '"estAdmin" is NOT TRUE AND "estOrganisateur" IS TRUE ORDER BY ' . "{$this->getOrderColumn()} LIMIT 10");
        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }
        return $dataObjects;
    }

    public function selectAllOrderedUtilisateurWithLimit(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()}  WHERE" . '"estAdmin" is NOT TRUE AND "estOrganisateur" IS NOT TRUE ORDER BY ' . "{$this->getOrderColumn()} LIMIT 10");
        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }
        return $dataObjects;
    }



}