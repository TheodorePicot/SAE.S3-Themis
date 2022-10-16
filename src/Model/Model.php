<?php

require_once "Conf.php";

class Model {
    private PDO $pdo;
    private static ?Model $instance = null;
    /**
     * @param $pdo
     */
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host='.Conf::getHostname().';port='.Conf::getPort().';dbname='.Conf::getDatabase().';user='.Conf::getLogin().';password='.Conf::getPassword());
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        $this->pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
    }

    static function getPdo() : PDO {
        return static::getInstance()->pdo;
    }

    private static function getInstance() : Model {
        // L'attribut statique $pdo s'obtient avec la syntaxe static::$pdo
        // au lieu de $this->pdo pour un attribut non statique
        if (is_null(static::$instance))
            // Appel du constructeur
            static::$instance = new Model();
        return static::$instance;
    }

    /**
     * @param mixed $pdo
     */
    public function setPdo($pdo): void
    {
        $this->pdo = $pdo;
    }
}
