<?php

namespace App\Service;

use PDO;

class DatabaseService
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            $_ENV['DATABASE_URL'],
            $_ENV['DATABASE_USER'],
            $_ENV['DATABASE_PASSWORD'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
