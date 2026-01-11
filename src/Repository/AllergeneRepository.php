<?php

namespace App\Repository;

use App\Entity\Allergene;
use PDO;

class AllergeneRepository extends BaseRepository
{
    protected string $table = 'allergene';

    protected function map(array $row): Allergene
    {
        return new Allergene(
            (int)$row['id'],
            $row['libelle']
        );
    }

    public function insert(Allergene $allergene): bool
    {
        $sql = "INSERT INTO $this->table (libelle)
                VALUES (:libelle)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['libelle' => $allergene->getLibelle()]);
    }

    public function update(Allergene $allergene): bool
    {
        $sql = "UPDATE $this->table SET libelle = :libelle
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $allergene->getLibelle(),
            'id' => $allergene->getId()
        ]);
    }
}
