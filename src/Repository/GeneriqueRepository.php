<?php

namespace App\Repository;

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
        if ($table == "")
        {
            return [];
        }

        $sql = "SELECT *
                FROM {$table}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $tabRetour = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $tabRetour[$row['id']] = $row;
        }

        return $tabRetour;
    }

    public function findById(string $table, int $id): array
    {
        if ($table == "")
        {
            return [];
        }

        $sql = "SELECT *
                FROM {$table}
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
