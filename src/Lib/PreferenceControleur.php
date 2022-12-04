<?php

namespace Themis\Lib;

use Themis\Model\HTTP\Cookie;

class PreferenceControleur
{
    private static string $clePreference = "preferenceControleur";

    public static function enregistrer(string $preference): void
    {
        Cookie::save(static::$clePreference, $preference);
    }

    public static function lire(): string
    {
        return Cookie::read(self::$clePreference);
    }

    public static function existe(): bool
    {
        return Cookie::contains(self::$clePreference);
    }

    public static function supprimer(): void
    {
        Cookie::delete(self::$clePreference);
    }
}

