<?php

namespace Themis\Config;

class Conf
{
    static private array $databases = array(
        'hostname' => 'themis-db-instance.cnowxclkulrh.eu-west-3.rds.amazonaws.com',
        'port' => '5432',
        'database' => 'themis',
        'login' => 'themis',
        'password' => 'Themis2022'
    );

    static public function getLogin(): string
    {
        return static::$databases['login'];
    }

    static public function getPort(): string
    {
        return static::$databases['port'];
    }

    static public function getHostname(): string
    {
        return static::$databases['hostname'];
    }

    static public function getDatabase(): string
    {
        return static::$databases['database'];
    }

    static public function getPassword(): string
    {
        return static::$databases['password'];
    }
}

