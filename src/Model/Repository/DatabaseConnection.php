<?php

namespace Themis\Model\Repository;

use PDO;
use Themis\Config\Conf;

class DatabaseConnection
{
    private static ?DatabaseConnection $instance = null;
    private PDO $pdo;

    /**
     * @param $pdo
     */
    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=' . Conf::getHostname() . ';port=' . Conf::getPort() . ';dbname=' . Conf::getDatabase() . ';user=' . Conf::getLogin() . ';password=' . Conf::getPassword());
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
    }

    static function getPdo(): PDO
    {
        return static::getInstance()->pdo;
    }

    private static function getInstance(): DatabaseConnection
    {
        if (is_null(static::$instance))
            static::$instance = new DatabaseConnection();
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
