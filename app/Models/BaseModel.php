<?php

namespace App\Models;

use App\Config\Database;

abstract class BaseModel
{
    protected static $pdo;

    public function __construct()
    {
        self::$pdo = Database::getInstance();
    }

    protected static function executeQuery(string $sql, array $params = [])
    {
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}
