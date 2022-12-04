<?php

namespace Themis\Model\HTTP;

class Cookie
{
    public static function save(string $key, mixed $value, ?int $durationBeforeExpiration = null): void
    {
        if ($durationBeforeExpiration == null) {
            setcookie($key, serialize($value), 0);
        } else {
            setcookie($key, serialize($value), $durationBeforeExpiration);
        }
    }

    public static function read(string $key): mixed
    {
        return unserialize($_COOKIE[$key]);
    }

    public static function contains($key): bool
    {
        return isset($_COOKIE[$key]);
    }

    public static function delete($key): void
    {
        unset($_COOKIE["$key"]);
        setcookie("$key", "", 1);
    }
}
