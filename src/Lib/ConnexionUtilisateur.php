<?php

namespace Themis\Lib;

use Themis\Model\HTTP\Session;
use Themis\Model\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    private static string $connectionKey = "connectedUser";

    public static function connect(string $loginUtilisateur): void
    {
        $session = Session::getInstance();
        $session->save(self::$connectionKey, $loginUtilisateur);
    }

    public static function disconnect(): void
    {
        $session = Session::getInstance();
        $session->delete(self::$connectionKey);
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

    public static function isUser($login): bool{
        return (self::isConnected() && self::getConnectedUserLogin()==$login);
    }

    public static function isAdministrator() : bool {
        $user = self::getConnectedUserLogin();
        if ($user==null) return false;
        $adminOuPas = (new UtilisateurRepository())->select($user);
        $tab = $adminOuPas->tableFormat();
        if ($tab['estAdmin']==1)return true;
        else return false;
    }
}


