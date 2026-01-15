<?php

namespace App\Repository;

use App\Entity\Regime;
use PDO;

class RegimeRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Regime $regime): bool
    {
        $sql = "INSERT INTO regime (libelle, description)
                VALUES (:libelle, :description)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $regime->getLibelle(),
            'description' => $regime->getDescription()
        ]);
    }

    public function update(Regime $regime): bool
    {
        $sql = "UPDATE regime
                SET libelle=:libelle, description=:description
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $regime->getLibelle(),
            'description' => $regime->getDescription(),
            'id' => $regime->getId()
        ]);
    }
}
