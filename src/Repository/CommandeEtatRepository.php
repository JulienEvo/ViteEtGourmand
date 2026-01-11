<?php

namespace App\Repository;

use App\Entity\CommandeEtat;
use PDO;

class CommandeEtatRepository extends BaseRepository
{
    protected string $table = 'commande_etat';

    protected function map(array $row): CommandeEtat
    {
        return new CommandeEtat((int)$row['id'], $row['libelle']);
    }

    public function insert(CommandeEtat $etat): bool
    {
        $sql = "INSERT INTO {$this->table} (libelle)
                VALUES (:libelle)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['libelle' => $etat->getLibelle()]);
    }

    public function update(CommandeEtat $etat): bool
    {
        $sql = "UPDATE {$this->table} SET libelle = :libelle WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $etat->getLibelle(),
            'id' => $etat->getId()
        ]);
    }
}
