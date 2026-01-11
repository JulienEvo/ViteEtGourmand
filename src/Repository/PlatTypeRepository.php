<?php

namespace App\Repository;

use App\Entity\PlatType;
use PDO;

class PlatTypeRepository extends BaseRepository
{
    protected string $table = 'plat_type';

    protected function map(array $row): PlatType
    {
        return new PlatType(
            (int)$row['id'],
            $row['libelle']
        );
    }

    public function insert(PlatType $type): bool
    {
        $sql = "INSERT INTO {$this->table} (libelle)
                VALUES (:libelle)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['libelle' => $type->getLibelle()]);
    }

    public function update(PlatType $type): bool
    {
        $sql = "UPDATE {$this->table}
                SET libelle=:libelle
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $type->getLibelle(),
            'id' => $type->getId()
        ]);
    }
}
