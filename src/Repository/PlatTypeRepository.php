<?php

namespace App\Repository;

use PDO;

class PlatTypeRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findAll(): array
    {
        $sql = "SELECT *
                FROM plat_type";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $plat_types = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $plat_types[$row['id']] = $row;
        }

        return $plat_types;
    }

}
