<?php

namespace Themis\Model\DataObject;

class Utilisateur extends AbstractDataObject
{
    private string $login;
    private string $nom;
    private string $prenom;
    private string $adresseMail;
    private string $dateNaissance;
    private string $mdp;

    /**
     * @param string $login
     * @param string $nom
     * @param string $prenom
     * @param string $adresseMail
     * @param string $dateNaissance
     * @param string $mdp
     */
    public function __construct(string $login, string $nom, string $prenom, string $adresseMail, string $dateNaissance, string $mdp)
    {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->adresseMail = $adresseMail;
        $this->dateNaissance = $dateNaissance;
        $this->mdp = $mdp;
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
        ];
    }
}