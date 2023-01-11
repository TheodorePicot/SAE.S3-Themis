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

    /**
     * permet de construire un Utilisateur à partir d'un login, d'un nom, d'un prenom, d'une adresseMail,
     * d'une dateNaissance, d'un mdp, d'un estAdmin, d'un estOrganisateur, d'un emailAValider et d'un nonce
     *
     * @param string $login
     * @param string $nom
     * @param string $prenom
     * @param string|null $adresseMail
     * @param string|null $dateNaissance
     * @param string $mdp
     * @param int $estAdmin
     * @param int $estOrganisateur
     * @param string|null $emailAValider
     * @param string|null $nonce
     */
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

    /**
     * permet de retourner toutes les colonnes de la table Utilisateur
     *
     * @return array
     */
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
     * permet de récupérer le login d'un Utilisateur
     *
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * permet de récupérer le nom d'un Utilisateur
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * permet de récupérer le prenom d'un Utilisateur
     *
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * permet de récupérer l'adresse mail d'un Utilisateur
     *
     * @return string
     */
    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    /**
     * permet de récupérer la dateNaissance d'un Utilisateur
     *
     * @return string
     */
    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    /**
     * permet de récupérer le mdp d'un Utilisateur
     *
     * @return string
     */
    public function getMdp(): string
    {
        return $this->mdp;
    }

    /**
     * permet de récupérer le Nonce d'un Utilisateur
     *
     * @return string
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }

    /**
     * permet de récupérer l'email a valider d'un Utilisateur
     *
     * @return string
     */
    public function getEmailAValider(): ?string
    {
        return $this->emailAValider;
    }

    /**
     * permet de savoir si un Utilisateur est Admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->estAdmin;
    }

    /**
     * permet de savoir si un Utilisateur est Organisateur
     *
     * @return bool
     */
    public function isOrganisateur(): bool
    {
        return $this->estOrganisateur;
    }

    /**
     * permet de mettre à jour estAdmin d'un Utilisateur
     *
     * @param bool $estAdmin
     */
    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }

    /**
     * permet de mettre à jour EstOrganisateur d'un Utilisateur
     *
     * @param bool $estOrganisateur
     */
    public function setEstOrganisateur(bool $estOrganisateur): void
    {
        $this->estOrganisateur = $estOrganisateur;
    }

    /**
     * permet de mettre à jour MdpHache d'un Utilisateur
     *
     * @param string $mdpHache
     */
    public function setMdpHache(string $mdpHache)
    {
        $this->mdp = PassWord::hash($mdpHache);
    }

    /**
     * permet de mettre à jour EmailAValider d'un Utilisateur
     *
     * @param string|null $emailAValider
     */
    public function setEmailAValider(?string $emailAValider): void
    {
        $this->emailAValider = $emailAValider;
    }

    /**
     * permet de mettre à jour AdresseMail d'un Utilisateur
     *
     * @param string|null $adresseMail
     */
    public function setAdresseMail(?string $adresseMail): void
    {
        $this->adresseMail = $adresseMail;
    }

    /**
     * permet de mettre à jour Nonce d'un Utilisateur
     *
     * @param string|null $nonce
     */
    public function setNonce(?string $nonce): void
    {
        $this->nonce = $nonce;
    }

    /**
     * permet de construire un Utilisateur à partir d'une array
     *
     * @param array $formArray
     * @return Utilisateur
     */
    public static function buildFromFormCreate(array $formArray): Utilisateur // TODO email a valider
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

    /**
     * permet de mettre à jour un Utilisateur à partir d'une array
     *
     * @param array $formArray
     * @return Utilisateur
     */
    public static function buildFromForm(array $formArray): Utilisateur
    {
        echo "la date de naissance : " . $formArray['dateNaissance'];
        $utilisateur = new Utilisateur (
            $formArray['login'],
            $formArray['nom'],
            $formArray['prenom'],
            $formArray['adresseMail'] ,
            $formArray['dateNaissance'] == "" ? null:$formArray['adresseMail'],
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