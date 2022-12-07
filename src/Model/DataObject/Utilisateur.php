<?php

namespace Themis\Model\DataObject;

use Themis\Lib\PassWord;

class Utilisateur extends AbstractDataObject
{
    private string $login;
    private string $nom;
    private string $prenom;
    private string $adresseMail;
    private string $dateNaissance;
    private string $mdp;
    private int $estAdmin;
    private int $estOrganisateur;

    /**
     * @param string $login
     * @param string $nom
     * @param string $prenom
     * @param string $adresseMail
     * @param string $dateNaissance
     * @param string $mdp
     * @param bool $estAdmin
     * @param bool $estOrganisateur
     */
    public function __construct(string $login, string $nom, string $prenom, string $adresseMail, string $dateNaissance, string $mdp, bool $estAdmin, bool $estOrganisateur)
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresseMail = $adresseMail;
        $this->dateNaissance = $dateNaissance;
        $this->mdp = $mdp;
        $this->estAdmin = $estAdmin;
        $this->estOrganisateur = $estOrganisateur;
    }

    public function tableFormat(): array
    {
        return [
            "login" => $this->login,
            "nom" => $this->nom,
            "prenom" => $this->prenom,
            "adresseMail" => $this->adresseMail,
            "dateNaissance" => $this->dateNaissance,
            "mdp" => $this->mdp,
            "estAdmin" => $this->estAdmin,
            "estOrganisateur" => $this->estOrganisateur
        ];

    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @return string
     */
    public function getAdresseMail(): string
    {
        return $this->adresseMail;
    }

    /**
     * @return string
     */
    public function getDateNaissance(): string
    {
        return $this->dateNaissance;
    }

    /**
     * @return string
     */
    public function getMdp(): string
    {
        return $this->mdp;
    }

    /**
     * @return bool
     */
    public function isEstOrganisateur(): bool
    {
        return $this->estOrganisateur;
    }


    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->estAdmin;
    }

    public function isOrganisateur(): bool
    {
        return $this->estOrganisateur;
    }

    /**
     * @param bool $estAdmin
     */
    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }

    /**
     * @param bool $estOrganisateur
     */
    public function setEstOrganisateur(bool $estOrganisateur): void
    {
        $this->estOrganisateur = $estOrganisateur;
    }

    public function setMdpHache(string $mdpHache)
    {
        $this->mdp = PassWord::hash($mdpHache);
    }

    public static function buildFromForm(array $tableauFormulaire): Utilisateur
    {
        $utilisateur = new Utilisateur (
            $tableauFormulaire['login'],
            $tableauFormulaire['nom'],
            $tableauFormulaire['prenom'],
            $tableauFormulaire['adresseMail'],
            $tableauFormulaire['dateNaissance'],
            PassWord::hash($tableauFormulaire['mdp']),
            0,
            0);

        if (isset($_GET["estAdmin"]) && $_GET["estAdmin"] == "on") {
            $utilisateur->setEstAdmin(1);
        }
        if (isset($_GET["estOrganisateur"]) && $_GET["estOrganisateur"] == "on") {
            $utilisateur->setEstOrganisateur(1);
        }
        return $utilisateur;
    }
}