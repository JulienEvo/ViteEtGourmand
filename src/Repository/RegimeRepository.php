<?php

namespace App\Repository;

use App\Entity\Regime;
use PDO;

class RegimeRepository extends BaseRepository
{
    protected string $table = 'regime';

    protected function map(array $row): Regime
    {
        return new Regime(
            (int)$row['id'],
            $row['libelle'],
            $row['description']
        );
    }

    public function insert(Regime $regime): bool
    {
        $sql = "INSERT INTO {$this->table} (libelle, description)
                VALUES (:libelle, :description)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $regime->getLibelle(),
            'description' => $regime->getDescription()
        ]);
    }

    public function update(Regime $regime): bool
    {
        $sql = "UPDATE {$this->table}
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
