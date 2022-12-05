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
    private bool $estAdmin;

    /**
     * @param string $login
     * @param string $nom
     * @param string $prenom
     * @param string $adresseMail
     * @param string $dateNaissance
     * @param string $mdp
     */
    public function __construct(string $login, string $nom, string $prenom, string $adresseMail, string $dateNaissance, string $mdp, bool $estAdmin)
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresseMail = $adresseMail;
        $this->dateNaissance = $dateNaissance;
        $this->mdp = $mdp;
        $this->estAdmin = $estAdmin;
    }

    public function tableFormat(): array
    {
        if($this->estAdmin==true){
            return [
                "login" => $this->login,
                "nom" => $this->nom,
                "prenom" => $this->prenom,
                "adresseMail" => $this->adresseMail,
                "dateNaissance" => $this->dateNaissance,
                "mdp" => $this->mdp,
                "estAdmin" => 1
            ];
        }
        else {
            return [
                "login" => $this->login,
                "nom" => $this->nom,
                "prenom" => $this->prenom,
                "adresseMail" => $this->adresseMail,
                "dateNaissance" => $this->dateNaissance,
                "mdp" => $this->mdp,
                "estAdmin" => 0
            ];
        }

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
    public function isEstAdmin(): bool
    {
        return $this->estAdmin;
    }

    /**
     * @param bool $estAdmin
     */
    public function setEstAdmin(bool $estAdmin): void
    {
        $this->estAdmin = $estAdmin;
    }



    public static function buildFromForm(array $tableauFormulaire): Utilisateur
    {
        if (isset($_GET["estAdmin"])){
            $tableauFormulaire['estAdmin'] = 'on';
            return new Utilisateur (
                $tableauFormulaire['login'],
                $tableauFormulaire['nom'],
                $tableauFormulaire['prenom'],
                $tableauFormulaire['adresseMail'],
                $tableauFormulaire['dateNaissance'],
                PassWord::hash($tableauFormulaire['mdp']),
                $tableauFormulaire['estAdmin']
            );
        }
        else {
            $null = '';
            return new Utilisateur (
                $tableauFormulaire['login'],
                $tableauFormulaire['nom'],
                $tableauFormulaire['prenom'],
                $tableauFormulaire['adresseMail'],
                $tableauFormulaire['dateNaissance'],
                PassWord::hash($tableauFormulaire['mdp']),
                $null
            );
        }

    }
}