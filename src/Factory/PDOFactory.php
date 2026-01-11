<?php

namespace App\Factory;

use PDO;

class PDOFactory
{
    public static function create(string $url, string $user, string $pass): PDO
    {
        $parts = parse_url($url);

        $host = $parts['host'] ?? '127.0.0.1';
        $port = $parts['port'] ?? 3306;
        $db   = ltrim($parts['dbname'] ?? 'vite_et_gourmand', '/');

        $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $host, $port, $db);

        try {
            return new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,]);
        } catch (\PDOException $e) {
            throw new \RuntimeException(
                'Connexion BDD impossible : ' . $e->getMessage()
            );
        }
    }
}
