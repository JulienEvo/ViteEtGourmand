<?php

namespace App\Factory;

use PDO;

class PDOFactory
{
    public static function create(): PDO
    {
        $url = $_ENV['DATABASE_URL'];

        $parts = parse_url($url);

        $host = $parts['host'];
        $port = $parts['port'] ?? 3306;
        $dbname = ltrim($parts['path'], '/');
        $user = $_ENV['DATABASE_USER']; //$parts['user'];
        $pass = $_ENV['DATABASE_PASSWORD']; //$parts['pass'];

        try {
            return new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (\PDOException $e) {
            throw new \RuntimeException(
                'Connexion BDD impossible : '.$e->getMessage()
            );
        }
    }
}
