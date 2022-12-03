<?php

namespace Themis\Lib;

use Themis\Model\HTTP\Session;

class ConnexionUtilisateur
{
    // L'utilisateur connecté sera enregistré en session associé à la clé suivante
    private static string $cleConnexion = "_utilisateurConnecte";

    public static function connecter(string $loginUtilisateur): void
    {
        $s = Session::getInstance();
        $s->save(self::$cleConnexion, $loginUtilisateur);
    }

    public static function estConnecte(): bool
    {
        $s = Session::getInstance();
        return $s->contains(self::$cleConnexion);
    }

    public static function deconnecter(): void
    {
        $s = Session::getInstance();
        $s->delete(self::$cleConnexion);
    }

    public static function getLoginUtilisateurConnecte(): ?string
    {
        $s = Session::getInstance();
        if (!self::estConnecte()){
            return null;
        }
        else{
        return $s->read(self::$cleConnexion);
        }
    }
}


