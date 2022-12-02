<?php

namespace Themis\Lib;

use Themis\Model\HTTP\Cookie;

class PreferenceControleur {

    private static string $clePreference = "preferenceControleur";

    public static function enregistrer(string $preference) : void
    {
        Cookie::enregistrer(static::$clePreference, $preference);
    }

    public static function lire() : string
    {
        $v = Cookie::lire(self::$clePreference);
        return $v;
    }

    public static function existe() : bool
    {
        return Cookie::contient(self::$clePreference);
    }

    public static function supprimer() : void
    {
        Cookie::supprimer(self::$clePreference);
    }
}

