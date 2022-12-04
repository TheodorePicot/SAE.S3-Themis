<?php

namespace Themis\Lib;

use Themis\Model\HTTP\Session;

class ConnexionUtilisateur
{
    private static string $connectionKey = "connectedUser";

    public static function connect(string $loginUtilisateur): void
    {
        $session = Session::getInstance();
        $session->save(self::$connectionKey, $loginUtilisateur);
    }

    public static function isConnected(): bool
    {
        $session = Session::getInstance();
        return $session->contains(self::$connectionKey);
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
}


