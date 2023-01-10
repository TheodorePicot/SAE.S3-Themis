<?php

namespace Themis\Model\HTTP;

class Cookie
{
    /**
     * Permet de déposer et sauvegarder un Cookie
     *
     *
     * @param string $key
     * @param mixed $value
     * @param int|null $durationBeforeExpiration
     * @return void
     */
    public static function save(string $key, mixed $value, ?int $durationBeforeExpiration = null): void
    {
        if ($durationBeforeExpiration == null) {
            setcookie($key, serialize($value), 0);
        } else {
            setcookie($key, serialize($value), $durationBeforeExpiration);
        }
    }

    /**
     * Permet lire un Cookie à partir de sa $key
     *
     * @param string $key
     * @return mixed
     */
    public static function read(string $key): mixed
    {
        return unserialize($_COOKIE[$key]);
    }

    /**
     * Permet de verifier si le Cookie avec la $key en paramètre existe
     *
     * @param string $key
     * @return bool
     */
    public static function contains(string $key): bool
    {
        return isset($_COOKIE[$key]);
    }

    /**
     * Permet de supprimer le Cookie avec la $key en paramètre
     *
     * @param string $key
     * @return void
     */
    public static function delete(string $key): void
    {
        unset($_COOKIE["$key"]);
        setcookie("$key", "", 1);
    }
}
