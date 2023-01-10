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


    /**
     * @inheritDoc
     */
    protected function getTableName(): string
    {
        return 'themis."Utilisateurs"';
    }

    /**
     * @inheritDoc
     */
    protected function getPrimaryKey(): string
    {
        return "login";
    }

    /**
     * @inheritDoc
     */
    protected function getOrderColumn(): string
    {
        return "login";
    }

    /**
     * @inheritDoc
     */
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

    /**
     * Permet à un utilisateur ses informations avec le tableau placé en paramètre
     *
     * @param array $newValues
     * @return void
     */
    public function updateInformation(array $newValues): void
    {
        var_dump($newValues);
        $sqlQuery = 'UPDATE ' . $this->getTableName() . ' SET nom =:nom, prenom =:prenom, "adresseMail" =:adresseMail, "dateNaissance" =:dateNaissance, "estAdmin" =:estAdmin, "estOrganisateur" =:estOrganisateur WHERE login =:login';
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $pdoStatement->execute($newValues);
    }

    /**
     * Permet à un utilisateur de mettre à jour son mot de passe
     *
     * @param array $newValues
     * @return void
     */
    public function updatePassword(array $newValues): void
    {
        var_dump($newValues);
        $sqlQuery = "UPDATE {$this->getTableName()} SET mdp =:mdp WHERE login =:login";
        echo $sqlQuery;
        $pdoStatement = DatabaseConnection::getPdo()->prepare($sqlQuery);
        $pdoStatement->execute($newValues);
    }


    /**
     * Permet d'obtenir une liste de tout les utilisateurs possédant le sting placé en paramètre dans leur login
     *
     * @param string $element
     * @return array
     */
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

    /**
     * Permet d'obtenir une liste de tout les administrateurs possédant le sting placé en paramètre dans leur login
     *
     * @param string $element
     * @return array
     */
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

    /**
     * Permet d'obtenir une liste de tout les utilistateurs qui sont des organisateurs et non des administrateurs, possédant le sting
     * placé en paramètre dans leur login
     *
     * @param string $element
     * @return array
     */
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

    /**
     * Permet d'obtenir une liste de tout les utilistateurs qui sont ni des organisateurs et ni des administrateurs, possédant le sting
     * placé en paramètre dans leur login
     *
     * @param string $element
     * @return array
     */
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


    /**
     * Permet d'obtenir une liste de 10 administrateurs
     *
     * @return array
     */
    public function selectAllOrderedAdminWithLimit(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()} WHERE" . '"estAdmin" is TRUE ORDER BY ' . "{$this->getOrderColumn()} LIMIT 10");
        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }
        return $dataObjects;
    }

    /**
     * Permet d'obtenir une liste de 10 utilistateurs qui sont des organisateurs et non des administrateurs
     *
     * @return array
     */
    public function selectAllOrderedOrganisateurWithLimit(): array
    {
        $pdoStatement = DatabaseConnection::getPdo()->query("SELECT * FROM {$this->getTableName()}  WHERE" . '"estAdmin" is NOT TRUE AND "estOrganisateur" IS TRUE ORDER BY ' . "{$this->getOrderColumn()} LIMIT 10");
        $dataObjects = array();
        foreach ($pdoStatement as $dataObject) {
            $dataObjects[] = $this->build($dataObject);
        }
        return $dataObjects;
    }

    /**
     * Permet d'obtenir une liste de 10 utilistateurs qui sont ni des organisateurs et ni des administrateurs
     *
     * @return array
     */
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