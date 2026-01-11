<?php

namespace App\Repository;

use App\Entity\Generique;
use PDO;

class GeneriqueRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(string $table): array
    {
        $sql = "SELECT *
                FROM {$table}
                WHERE 1 ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(string $table, int $id)
    {
        $sql = "SELECT *
                FROM {$table}
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
