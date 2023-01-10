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

    /**
     * Permet creer une Session si $instance est null sinon return $instance
     *
     * @return Session
     */
    public static function getInstance(): Session
    {
        if (is_null(static::$instance))
            static::$instance = new Session();
        return static::$instance;
    }

    /**
     * Permet de verifier si la Session avec le $name en paramètre existe
     *
     * @param $name
     * @return bool
     */
    public function contains($name): bool
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Permet de créer un sauvegarder un Session avec son $name et sa $value
     *
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public function save(string $name, mixed $value): void
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Permet lire une Session à partir de son $name
     *
     * @param string $name
     * @return mixed
     */
    public function read(string $name): mixed
    {
        return $_SESSION[$name];
    }

    /**
     * Permet de supprimer la Session dans le tableau $_SESSION avec la $key en paramètre
     *
     * @param string $key
     * @return void
     */
    public function delete($name): void
    {
        unset($_SESSION[$name]);
    }

    /**
     * Permet de supprimer complètement une session avec notamment la suppression du cookie de session
     *
     * @param string $key
     * @return void
     */
    public function destroy() : void
    {
        session_unset();
        session_destroy();
        Cookie::delete(session_name());
        $instance = null;
    }
}
