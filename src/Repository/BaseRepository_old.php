<?php

namespace App\Repository;

use App\Entity\Generique;
use App\Entity\Regime;
use App\Service\FonctionsService;
use PDO;

abstract class BaseRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function findById(int $id)
    {
        $sql = "SELECT *
                FROM plat
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->map($row);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM plat WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
