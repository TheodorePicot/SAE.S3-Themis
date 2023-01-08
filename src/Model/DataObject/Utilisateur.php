<?php

namespace Themis\Model\DataObject;

use Themis\Lib\PassWord;

class Utilisateur extends AbstractDataObject
{
    private string $login;
    private string $nom;
    private string $prenom;
    private ?string $adresseMail;
    private ?string $dateNaissance;
    private string $mdp;
    private int $estAdmin;
    private int $estOrganisateur;
    private ?string $emailAValider;
    private ?string $nonce;

    public function __construct(string  $login,
                                string  $nom,
                                string  $prenom,
                                ?string $adresseMail,
                                ?string $dateNaissance,
                                string  $mdp,
                                bool    $estAdmin,
                                bool    $estOrganisateur,
                                ?string $emailAValider,
                                ?string $nonce)
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
            "nonce" => $this->nonce,
            "emailAValider" => $this->emailAValider
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
    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    /**
     * @return string
     */
    public function getDateNaissance(): ?string
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
     * @return string
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }

    /**
     * @return string
     */
    public function getEmailAValider(): string
    {
        return $this->emailAValider;
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

    /**
     * @param string|null $emailAValider
     */
    public function setEmailAValider(?string $emailAValider): void
    {
        $this->emailAValider = $emailAValider;
    }

    /**
     * @param string|null $adresseMail
     */
    public function setAdresseMail(?string $adresseMail): void
    {
        $this->adresseMail = $adresseMail;
    }

    /**
     * @param string|null $nonce
     */
    public function setNonce(?string $nonce): void
    {
        $this->nonce = $nonce;
    }

    public static function buildFromFormCreate(array $formArray): Utilisateur
    {
        $utilisateur = new Utilisateur (
            $formArray['login'],
            $formArray['nom'],
            $formArray['prenom'],
            $formArray['adresseMail'],
            $formArray['dateNaissance'],
            PassWord::hash($formArray['mdp']),
            0,
            0,
            $formArray['adresseMail'],
            PassWord::generateRandomString()
        );

        if (isset($formArray["estAdmin"]) && $formArray["estAdmin"] == "on") {
            $utilisateur->setEstAdmin(1);
        }
        if (isset($formArray["estOrganisateur"]) && $formArray["estOrganisateur"] == "on") {
            $utilisateur->setEstOrganisateur(1);
        }
//        var_dump($formArray);
        return $utilisateur;
    }

    public static function buildFromForm(array $formArray): Utilisateur
    {
        $utilisateur = new Utilisateur (
            $formArray['login'],
            $formArray['nom'],
            $formArray['prenom'],
            $formArray['adresseMail'],
            $formArray['dateNaissance'],
            PassWord::hash($formArray['mdp']),
            0,
            0,
            null,
            null
        );

        if (isset($formArray["estAdmin"]) && $formArray["estAdmin"] == "on") {
            $utilisateur->setEstAdmin(1);
        }
        if (isset($formArray["estOrganisateur"]) && $formArray["estOrganisateur"] == "on") {
            $utilisateur->setEstOrganisateur(1);
        }
//        var_dump($formArray);
        return $utilisateur;
    }
}