<?php

namespace App\Repository;

use App\Entity\Generique;
use App\Entity\Regime;
use App\Service\FonctionsService;
use PDO;

abstract class BaseRepository
{
    protected PDO $pdo;
    protected string $table;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    abstract protected function map(array $row);

    /*
    public function findAll(string $whereSupp = '', array $varsSupp = [], string $generiqueTable = ''): array
    {
        if (empty($generiqueTable))
        {
            $tb = $this->table;
        }
        else{
            $tb = $generiqueTable;
        }

        $sql = "SELECT *
                FROM {$tb}
                WHERE 1 ";

        if (!empty($whereSupp)) {
            $sql .= " {$whereSupp}";
        }

        if (!empty($generiqueTable))
        {
            // pour les classes Generique
            $sql .= " ORDER BY {$generiqueTable}.libelle";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($varsSupp);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'map'], $rows);
    }
    */

    public function findById(int $id)
    {
        $sql = "SELECT *
                FROM {$this->table}
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $this->map($row);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}
