<?php

namespace App\Repository;

use App\Entity\CommandeEtat;
use PDO;

class CommandeEtatRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(CommandeEtat $etat): bool
    {
        $sql = "INSERT INTO commande_etat (libelle)
                VALUES (:libelle)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['libelle' => $etat->getLibelle()]);
    }

    public function update(CommandeEtat $etat): bool
    {
        $sql = "UPDATE commande_etat SET libelle = :libelle WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $etat->getLibelle(),
            'id' => $etat->getId()
        ]);
    }
}
