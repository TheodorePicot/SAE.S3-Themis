<?php

namespace Themis\Model\HTTP;

use Exception;

class Session
{
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
    }

    public static function getInstance(): Session
    {
        if (is_null(static::$instance))
            static::$instance = new Session();
        return static::$instance;
    }

    public function contains($name): bool
    {
        return isset($_SESSION[$name]);
    }

    public function save(string $name, mixed $value): void
    {
        $_SESSION[$name] = $value;
    }

    public function read(string $name): mixed
    {
        return $_SESSION[$name];
    }

    public function delete($name): void
    {
        unset($_COOKIE[$name]);
    }

    public function destroy() : void
    {
        session_unset();
        session_destroy();
        Cookie::delete(session_name());
        $instance = null;
    }
}
