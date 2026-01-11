<?php

namespace App\Repository;

use App\Entity\Condition;
use PDO;

class ConditionRepository extends BaseRepository
{
    protected string $table = 'condition';

    protected function map(array $row): condition
    {
        return new condition((int)$row['id'], $row['libelle'], $row['description']);
    }

    public function insert(condition $condition): bool
    {
        $sql = "INSERT INTO {$this->table} (libelle, description) VALUES (:libelle, :description)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $condition->getLibelle(),
            'description' => $condition->getDescription()
        ]);
    }

    public function update(condition $condition): bool
    {
        $sql = "UPDATE {$this->table} SET libelle=:libelle, description=:description WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $condition->getLibelle(),
            'description' => $condition->getDescription(),
            'id' => $condition->getId()
        ]);
    }
}
