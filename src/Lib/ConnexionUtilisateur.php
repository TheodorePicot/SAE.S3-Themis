<?php

namespace Themis\Lib;

use Themis\Model\HTTP\Session;
use Themis\Model\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    private static string $connectionKey = "connectedUser";
    private static string $isOrganisateur = "isOrganisateur";
    private static string $idAdministrator = "isAdministrator";

    public static function connect(string $loginUtilisateur): void
    {
        $session = Session::getInstance();
        $session->save(self::$connectionKey, $loginUtilisateur);
        $session->save(self::$idAdministrator, self::isAdministrator());
        $session->save(self::$isOrganisateur, self::isOrganisateur());
    }

    public static function disconnect(): void
    {
        $session = Session::getInstance();
        $session->delete(self::$connectionKey);
        $session->delete(self::$idAdministrator);
        $session->delete(self::$isOrganisateur);
    }

    public static function getConnectedUserLogin(): ?string
    {
        $session = Session::getInstance();
        if (!self::isConnected()) {
            return null;
        } else {
            return $session->read(self::$connectionKey);
        }
    }

    public static function isConnected(): bool
    {
        $session = Session::getInstance();
        return $session->contains(self::$connectionKey);
    }

    public static function isUser($login): bool
    {
        return (self::isConnected() && self::getConnectedUserLogin() == $login);
    }

    public static function isAdministrator(): bool
    {
        $session = Session::getInstance();
        if ($session->contains(self::$idAdministrator)) return $session->read(self::$idAdministrator);

        $user = self::getConnectedUserLogin();
        if ($user == null) return false;

        $adminOuPas = (new UtilisateurRepository())->select($user);
        $tab = $adminOuPas->tableFormat();
        if ($tab['estAdmin'] == 1) return true;
        else return false;
    }

    public static function isOrganisateur(): bool
    {
        $session = Session::getInstance();
        if ($session->contains(self::$isOrganisateur)) return $session->read(self::$isOrganisateur);

        $user = self::getConnectedUserLogin();
        if ($user == null) return false;

        $organisateurOuPas = (new UtilisateurRepository())->select($user);
        $tab = $organisateurOuPas->tableFormat();
        if ($tab['estOrganisateur'] == 1) return true;
        else return false;
    }
}


