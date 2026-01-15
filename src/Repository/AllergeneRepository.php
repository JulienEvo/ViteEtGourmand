<?php

namespace App\Repository;

use App\Entity\Allergene;
use PDO;

class AllergeneRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Allergene $allergene): bool
    {
        $sql = "INSERT INTO allergene (libelle, description)
                VALUES (:libelle, :description)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['libelle' => $allergene->getLibelle(), 'description' => $allergene->getDescription()]);
    }

    public function update(Allergene $allergene): bool
    {
        $sql = "UPDATE allergene SET libelle = :libelle, description = :description
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $allergene->getLibelle(),
            'description' => $allergene->getDescription(),
            'id' => $allergene->getId()
        ]);
    }
}
