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
    private string $emailAValider;
    private string $nonce;

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
    public function __construct(string $login, string $nom, string $prenom, string $adresseMail, string $dateNaissance, string $mdp, bool $estAdmin, bool $estOrganisateur, string $emailAValider, string $nonce)
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresseMail = $adresseMail;
        $this->dateNaissance = $dateNaissance;
        $this->mdp = $mdp;
        $this->estAdmin = $estAdmin;
        $this->estOrganisateur = $estOrganisateur;
        $this->emailAValider = $emailAValider;
        $this->nonce = $nonce;
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
            "estOrganisateur" => $this->estOrganisateur,
            "emailAValider"=> $this->emailAValider,
            "nonce" => $this->nonce
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
     * @return string
     */
    public function getEmailAValider(): string
    {
        return $this->emailAValider;
    }


    /**
     * @return string
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }

    /**
     * @param string $adresseMail
     */
    public function setAdresseMail(string $adresseMail): void
    {
        $this->adresseMail = $adresseMail;
    }


    /**
     * @param string $emailAValider
     */
    public function setEmailAValider(string $emailAValider): void
    {
        $this->emailAValider = $emailAValider;
    }
    /**
     * @param string $nonce
     */
    public function setNonce(string $nonce): void
    {
        $this->nonce = $nonce;
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
            "enAttente",
            $tableauFormulaire['dateNaissance'],
            PassWord::hash($tableauFormulaire['mdp']),
            0,
            0,
            $_GET['adresseMail'],
            PassWord::generateRandomString());

        if (isset($_GET["estAdmin"]) && $_GET["estAdmin"] == "on") {
            $utilisateur->setEstAdmin(1);
        }
        if (isset($_GET["estOrganisateur"]) && $_GET["estOrganisateur"] == "on") {
            $utilisateur->setEstOrganisateur(1);
        }
        return $utilisateur;
    }
}