<?php

namespace App\Config;

class Database
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        $this->connection = new \PDO(
            "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'],
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD']
        );
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }
}
