<?php

namespace Themis\Model\DataObject;

class Utilisateur
{
    private string $adresseMail;
    private string $nomUtilisateur;
    private string $prenomUtilisateur;
    private string $dateDeNaissance;

    /**
     * @param string $adresseMail
     * @param string $nomUtilisateur
     * @param string $prenomUtilisateur
     * @param string $dateDeNaissance
     */
    public function __construct(string $adresseMail, string $nomUtilisateur, string $prenomUtilisateur, string $dateDeNaissance)
    {
        $this->adresseMail = $adresseMail;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->prenomUtilisateur = $prenomUtilisateur;
        $this->dateDeNaissance = $dateDeNaissance;
    }
}